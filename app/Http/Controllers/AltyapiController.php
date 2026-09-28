<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Services\AltyapiService;


class AltyapiController extends Controller
{
    protected AltyapiService $altyapiService;

    public function __construct(AltyapiService $altyapiService)
    {
        $this->altyapiService = $altyapiService;
    }



    public function getAltyapiServicesForIssHizmetBolgeleri(int $ilId, int $ilceId, int $mahalleId, int $csbmId, int $binaId): JsonResponse {

        // 1️⃣ Bu adrese ait paketleri çek (JOIN)
        $packages = Package::query()
            ->select('packages.xdsltype', DB::raw('MAX(packages.download) as max_hiz'))
            ->join('package_areas', 'package_areas.package_id', '=', 'packages.id')
            ->where('package_areas.il_id', $ilId)
            ->where('package_areas.ilce_id', $ilceId)
            ->where('package_areas.mahalle_id', $mahalleId)
            ->where('package_areas.csbm_id', $csbmId)
            ->where('package_areas.bina_id', $binaId)
            ->groupBy('packages.xdsltype')
            ->get()
            ->keyBy('xdsltype');

        // 2️⃣ Fiber
        $fiberVarMi = $packages->has(7);
        $fiberMaxHiz = $fiberVarMi ? (int) $packages[7]->max_hiz : 0;

        // 3️⃣ VDSL
        $vdslVarMi = $packages->has(6);
        $vdslMaxHiz = $vdslVarMi ? (int) $packages[6]->max_hiz : 0;

        // 4️⃣ ADSL
        $adslVarMi = $packages->has(1);
        $adslMaxHiz = $adslVarMi ? (int) $packages[1]->max_hiz : 0;

        // 5️⃣ Gauge için en yüksek hız + altyapı türü
        $gaugeMaxHiz = max($fiberMaxHiz, $vdslMaxHiz, $adslMaxHiz);

        $gaugeAltyapiTuru = match ($gaugeMaxHiz) {
            $fiberMaxHiz => 'FIBER',
            $vdslMaxHiz  => 'VDSL',
            $adslMaxHiz  => 'ADSL',
            default      => 'Hizmet Verilememektedir',
        };

        // 6️⃣ Response
        return response()->json([
            'success' => true,
            'data' => [
                // Gauge
                'gauge_max_hiz' => $gaugeMaxHiz,
                'gauge_altyapi_turu' => $gaugeAltyapiTuru,

                // Fiber
                'iss_fiber_var_mi' => $fiberVarMi,
                'iss_fiber_hiz' => $fiberMaxHiz,

                // VDSL
                'iss_vdsl_var_mi' => $vdslVarMi,
                'iss_vdsl_hiz' => $vdslMaxHiz,

                // ADSL
                'iss_adsl_var_mi' => $adslVarMi,
                'iss_adsl_hiz' => $adslMaxHiz,
            ],
        ]);
    }



    public function getAltyapiServicesByBBK(int $bbk): JsonResponse
    {
    $getFiberAltyapiInfo = $this->altyapiService->fiberAltyapiSorgulama($bbk);
    $getVdslAltyapiInfo = $this->altyapiService->vdslAltyapiSorgulama($bbk);
    $getAdslAltyapiInfo = $this->altyapiService->adslAltyapiSorgulama($bbk);
        $fiberHiz = !empty($getFiberAltyapiInfo['fiber_var_mi'])
            ? (int) ($getFiberAltyapiInfo['hiz'] ?? 0)
            : 0;


        $vdslHiz = !empty($getVdslAltyapiInfo['vdsl_var_mi'])
            ? (int) ($getVdslAltyapiInfo['hiz'] ?? 0)
            : 0;

        $adslHiz = !empty($getAdslAltyapiInfo['adsl_var_mi'])
            ? (int) ($getAdslAltyapiInfo['hiz'] ?? 0)
            : 0;


        $gaugeMaxHiz = max($fiberHiz, $vdslHiz, $adslHiz);

        $gaugeAltyapiTuru = $gaugeMaxHiz > 0
            ? match ($gaugeMaxHiz) {
                $fiberHiz => 'Fiber Bağlantı',
                $vdslHiz  => 'VDSL Bağlantı',
                $adslHiz  => 'ADSL Bağlantı',
                default   => 'Hizmet Verilememektedir',
            }
            : 'Hizmet Verilememektedir';



        $data = [
            // Gauge
            'gauge_max_hiz' => $gaugeMaxHiz,
            'gauge_altyapi_turu' => $gaugeAltyapiTuru,
       //Fiber
        'fiber_var_mi'=> $getFiberAltyapiInfo['fiber_var_mi'],
        'fiber_santral_hizmet'=> $getFiberAltyapiInfo['santral_hizmet'],
        'fiber_bos_port'=> $getFiberAltyapiInfo['bos_port'],
        'fiber_hiz'=> $getFiberAltyapiInfo['hiz'],
        'fiber_santral_adi'=> $getFiberAltyapiInfo['santral_adi'],
        'fiber_santral_mudurluk_adi'=> $getFiberAltyapiInfo['santral_mudurluk_adi'],
        'fiber_santral_mesafe'=> $getFiberAltyapiInfo['santral_mesafe'],
        //Vdsl
        'vdsl_var_mi'=> $getVdslAltyapiInfo['vdsl_var_mi'],
        'vdsl_santral_hizmet'=> $getVdslAltyapiInfo['santral_hizmet'],
        'vdsl_bos_port'=> $getVdslAltyapiInfo['bos_port'],
        'vdsl_hiz'=> $getVdslAltyapiInfo['hiz'],
        'vdsl_santral_adi'=> $getVdslAltyapiInfo['santral_adi'],
        'vdsl_santral_mudurluk_adi'=> $getVdslAltyapiInfo['santral_mudurluk_adi'],
        'vdsl_santral_mesafe'=> $getVdslAltyapiInfo['santral_mesafe'],
        //Adsl
        'adsl_var_mi'=> $getAdslAltyapiInfo['adsl_var_mi'],
        'adsl_santral_hizmet'=> $getAdslAltyapiInfo['santral_hizmet'],
        'adsl_bos_port'=> $getAdslAltyapiInfo['bos_port'],
        'adsl_hiz'=> $getAdslAltyapiInfo['hiz'],
        'adsl_santral_adi'=> $getAdslAltyapiInfo['santral_adi'],
        'adsl_santral_mudurluk_adi'=> $getAdslAltyapiInfo['santral_mudurluk_adi'],
        'adsl_santral_mesafe'=> $getAdslAltyapiInfo['santral_mesafe'],
    ];
         return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }


}
