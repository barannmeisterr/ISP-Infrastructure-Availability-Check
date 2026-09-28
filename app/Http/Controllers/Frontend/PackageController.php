<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\IssProvider;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PackageController extends Controller
{


    public function index(Request $request)
    {
        $query = Package::query()
            ->with('provider');

        /* =============================
           ALTYAPI (ADSL / VDSL / FIBER)
        ============================== */
        if ($request->filled('altyapi')) {
            $xdslMap = [
                'ADSL'  => 1,
                'VDSL'  => 6,
                'FIBER' => 7,
            ];

            $types = collect($request->altyapi)
                ->map(fn($a) => $xdslMap[$a] ?? null)
                ->filter()
                ->values()
                ->toArray();

            if (!empty($types)) {
                $query->whereIn('xdsltype', $types);
            }
        }

        /* =============================
           ISS FİLTRESİ
        ============================== */
        if ($request->filled('iss')) {
            $query->whereHas('provider', function ($q) use ($request) {
                $q->whereIn('name', $request->iss);
            });
        }

        /* =============================
           FİYAT
        ============================== */
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int)$request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int)$request->max_price);
        }

        /* =============================
           İNDİRME HIZI
        ============================== */
        if ($request->filled('download_min')) {
            $query->where('download', '>=', (int)$request->download_min);
        }

        if ($request->filled('download_max')) {
            $query->where('download', '<=', (int)$request->download_max);
        }

        /* =============================
           YÜKLEME HIZI
        ============================== */
        if ($request->filled('upload_min')) {
            $query->where('upload', '>=', (int)$request->upload_min);
        }

        if ($request->filled('upload_max')) {
            $query->where('upload', '<=', (int)$request->upload_max);
        }

        /* =============================
           TAAHHÜT
           2 = tümü
        ============================== */
        if ($request->commitment !== null && $request->commitment != 2) {
            $query->where('commitment', (int)$request->commitment);
        }

        /* =============================
           KOTA
           2 = tümü
        ============================== */
        if ($request->quota !== null && $request->quota != 2) {
            $query->where('quota', (int)$request->quota);
        }

        /* =============================
           PAGINATION
        ============================== */
        $packages = $query
            ->orderBy('created_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        /* =============================
           BLADE İÇİN FORMAT
        ============================== */
        $packages->getCollection()->transform(function ($package) {
            return [
                'id'         => $package->id,
                'provider'   => $package->provider->name ?? '',
                'logo'  => $package->provider->logo_path ? asset($package->provider->logo_path) : null,
                'title'      => $package->title,
                'xdsltype'   => $package->xdsltype,
                'download'   => $package->download,
                'upload'     => $package->upload,
                'price'      => $package->price,
                'commitment' => $package->commitment,
                'quota'      => $package->quota,
                'ping'       => $package->ping,
            ];
        });

        $issler = IssProvider::orderBy('name')->pluck('name')->toArray();

        return view('paketler', compact('packages', 'issler'));
    }


    public function show($id)
    {
        // 1️⃣ Paket
        $package = Package::with('provider')->findOrFail($id);

        // 2️⃣ package_areas → unique şehirler
        $cities = \DB::table('package_areas')
            ->where('package_id', $package->id)
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->values()
            ->toArray();

        // 3️⃣ Response datası
        $packageData = [
            'id'               => $package->id,
            'provider'         => $package->provider->name ?? '',
            'title'            => $package->title,
            'xdsltype'         => $package->xdsltype,
            'download'         => $package->download,
            'upload'           => $package->upload,
            'price'            => $package->price,
            'commitment'       => $package->commitment,
            'commitment_month' => $package->commitment_month,
            'quota'            => $package->quota,
            'ping'             => $package->ping,
            'areas'            => $cities,
            'description'      => $package->description,
        ];

        return view('paket_detay', [
            'package' => (object) $packageData
        ]);
    }

}
