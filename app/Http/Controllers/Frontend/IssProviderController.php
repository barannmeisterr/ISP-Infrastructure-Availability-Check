<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\IssProvider;
use Illuminate\Http\Request;

class IssProviderController extends Controller
{
    public function index()
    {
        $issler = IssProvider::with('serviceAreas')
            ->get()
            ->sortBy(fn ($provider) => mb_strtolower($provider->name)) // ✅ name'e göre sırala
            ->values() // indexleri 0'dan başlat
            ->map(function ($provider) {
                return [
                    'name' => $provider->name,
                    'logo' => $provider->logo_path ? asset($provider->logo_path) : null,
                    'services' => $provider->services ? json_decode($provider->services, true) : [],
                    'location' => $provider->location,
                    'slug' => $provider->slug,
                ];
            })
            ->toArray();


        $search = request('search');
        $city = request('city');

        $filteredIss = array_filter($issler, function ($iss) use ($search, $city) {
            $nameOk = true;
            $cityOk = true;

            if ($search) {
                $nameOk = str_contains(
                    mb_strtolower($iss['name']),
                    mb_strtolower($search)
                );
            }

            if ($city) {
                $cityOk = mb_strtolower($iss['location'] ?? '') === mb_strtolower($city);
            }

            return $nameOk && $cityOk;
        });

        $cities = array_unique(array_filter(array_column($issler, 'location')));

        return view('saglayicilar', [
            'issler' => $filteredIss,
            'cities' => $cities,
            'search' => $search,
            'selectedCity' => $city
        ]);
    }

    public function show($slug)
    {
        $provider = IssProvider::with('serviceAreas', 'packages.provider', 'packages.areas')->where('slug', $slug)->firstOrFail();

        $issData = [
            'company_info' => $provider->company_info,
            'name' => $provider->name,
            'logo' => $provider->logo_path ? asset($provider->logo_path) : null,
            'services' => $provider->services ? json_decode($provider->services, true) : [],
            'location' => $provider->location,
            'packages' => $provider->packages->map(function($package) {
                return [
                    'id' => $package->id,
                    'provider' => $package->provider->name ?? '',
                    'title' => $package->title,
                    'xdsltype'   => $package->xdsltype,
                    'download' => $package->download,
                    'upload' => $package->upload,
                    'price' => $package->price,
                    'commitment' => $package->commitment,
                    'quota' => $package->quota,
                    'ping' => $package->ping,
                ];
            })->toArray(),
            'cagrimerkezi' => $provider->cagrimerkezi,
            'whatsappNo' => $provider->whatsapp_no,
            'fax' => $provider->fax,
            'eposta' => $provider->email,
            'website' => $provider->website,
            'unvan' => $provider->unvan,
            'adres' => $provider->address,
            'service_areas' => $provider->serviceAreas->pluck('city')->toArray(),
            'slug' => $provider->slug,
        ];

        return view('saglayici_profil', ['iss' => (object)$issData]);
    }
}
