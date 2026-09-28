<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class AltyapiSorguController extends Controller
{

    public function foundPackagesForTurkTelekom(int $ilId, int $ilceId, int $mahalleId, int $csbmId, int $binaId, int $fiber, int $vdsl, int $adsl, int $fiberSpeed, int $vdslSpeed, int $adslSpeed) {
        // 1️⃣ int → bool
        $isFiberVarMi = $fiber === 1;
        $isVdslVarMi  = $vdsl === 1;
        $isAdslVarMi  = $adsl === 1;

        if (!$isFiberVarMi && !$isVdslVarMi && !$isAdslVarMi) {
            return back()
                ->withInput()
                ->with('error', 'Adresinizde altyapı hizmeti bulunamamaktadır.');
        }

        // 2️⃣ xdsltype listesi
        $xdslTypes = [];
        if ($isFiberVarMi) $xdslTypes[] = 7;
        if ($isVdslVarMi)  $xdslTypes[] = 6;
        if ($isAdslVarMi)  $xdslTypes[] = 1;

        // 3️⃣ Paket sorgusu
        $packages = Package::query()
            ->whereHas('areas', function ($q) use ($ilId, $ilceId, $mahalleId, $csbmId, $binaId) {
                $q->where('il_id', $ilId)
                    ->where('ilce_id', $ilceId)
                    ->where('mahalle_id', $mahalleId)
                    ->where('csbm_id', $csbmId)
                    ->where('bina_id', $binaId);
            })
            ->whereIn('xdsltype', $xdslTypes)
            ->where(function ($q) use (
                $isFiberVarMi,
                $isVdslVarMi,
                $isAdslVarMi,
                $fiberSpeed,
                $vdslSpeed,
                $adslSpeed
            ) {
                if ($isFiberVarMi) {
                    $q->orWhere(function ($q) use ($fiberSpeed) {
                        $q->where('xdsltype', 7)
                            ->where('download', '<=', $fiberSpeed);
                    });
                }

                if ($isVdslVarMi) {
                    $q->orWhere(function ($q) use ($vdslSpeed) {
                        $q->where('xdsltype', 6)
                            ->where('download', '<=', $vdslSpeed);
                    });
                }

                if ($isAdslVarMi) {
                    $q->orWhere(function ($q) use ($adslSpeed) {
                        $q->where('xdsltype', 1)
                            ->where('download', '<=', $adslSpeed);
                    });
                }
            })
            ->with('provider')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($package) {
                return [
                    'id'         => $package->id,
                    'provider'   => $package->provider->name ?? '',
                    'title'      => $package->title,
                    'xdsltype'   => $package->xdsltype,
                    'download'   => $package->download,
                    'upload'     => $package->upload,
                    'price'      => $package->price,
                    'commitment' => $package->commitment,
                    'quota'      => $package->quota,
                    'ping'       => $package->ping,
                ];
            })
            ->toArray();

        return view('altyapi_sorgu_found_paketler', compact('packages'));
    }


    public function foundPackagesForIssAltyapi(int $ilId, int $ilceId, int $mahalleId, int $csbmId, int $binaId) {
        $packages = Package::query()
            ->whereHas('areas', function ($q) use (
                $ilId,
                $ilceId,
                $mahalleId,
                $csbmId,
                $binaId
            ) {
                $q->where('il_id', $ilId)
                    ->where('ilce_id', $ilceId)
                    ->where('mahalle_id', $mahalleId)
                    ->where('csbm_id', $csbmId)
                    ->where('bina_id', $binaId);
            })
            ->with('provider')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($package) {
                return [
                    'id'         => $package->id,
                    'provider'   => $package->provider->name ?? '',
                    'title'      => $package->title,
                    'xdsltype'   => $package->xdsltype,
                    'download'   => $package->download,
                    'upload'     => $package->upload,
                    'price'      => $package->price,
                    'commitment' => $package->commitment,
                    'quota'      => $package->quota,
                    'ping'       => $package->ping,
                ];
            })
            ->toArray();

        if (empty($packages)) {
            return back()
                ->withInput()
                ->with('error', 'Bu adreste ISS altyapısına ait paket bulunamadı.');
        }

        return view('altyapi_sorgu_found_paketler', compact('packages'));
    }

}
