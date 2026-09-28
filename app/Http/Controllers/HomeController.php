<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers;

use App\Models\HomeStat;
use App\Models\HomeHighlightedProvider;
use App\Models\HomeHighlightedPackage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // İstatistikler
        $stats = HomeStat::orderBy('order')->get()->map(function($stat) {
            return [
                'count' => $stat->count,
                'label' => $stat->label,
            ];
        })->toArray();

        // Öne çıkarılan ISS sağlayıcılar
        $populer_issler = HomeHighlightedProvider::with('provider.serviceAreas')
            ->orderBy('sort_order')
            ->get()
            ->map(function($highlighted) {
                $provider = $highlighted->provider;
                return [
                    'name' => $provider->name,
                    'logo' => $provider->logo_path ? asset($provider->logo_path) : null,
                    'services' => $provider->services ? json_decode($provider->services, true) : [],
                    'location' => $provider->location,
                    'slug' => $provider->slug,
                ];
            })->toArray();

        // Öne çıkarılan paketler
        $populer_paketler = HomeHighlightedPackage::with('package.provider')
            ->orderBy('sort_order')
            ->get()
            ->map(function($highlighted) {
                $package = $highlighted->package;
                return [
                    'id' => $package->id,
                    'provider' => $package->provider->name ?? '',
                    'title' => $package->title,
                    'xdsltype' => $package->xdsltype,
                    'download' => $package->download,
                    'upload' => $package->upload,
                    'price' => $package->price,
                    'commitment' => $package->commitment,
                    'quota' => $package->quota,
                    'ping' => $package->ping,
                ];
            })->toArray();

        // Eğer hiç veri yoksa boş array döndür
        if (empty($stats)) {
            $stats = [];
        }

        return view('welcome', compact('stats', 'populer_issler', 'populer_paketler'));
    }
}
