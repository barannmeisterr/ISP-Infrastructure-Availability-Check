<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers;

use App\Services\AdresService;
use Illuminate\Http\JsonResponse;

class UavtAdresController extends Controller
{
    protected AdresService $adresService;

    public function __construct(AdresService $adresService)
    {
        $this->adresService = $adresService;
    }

    public function iller(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->adresService->uavtIlListesiGetir()
        ]);
    }

    public function ilceler(int $il_id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->adresService->uavtIlceListesiGetir($il_id)
        ]);
    }

    public function bucaklar(int $ilce_id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->adresService->uavtBucakListesiGetir($ilce_id)
        ]);
    }

    public function mahalleler(int $bucak_id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->adresService->uavtMahalleListesiGetir($bucak_id)
        ]);
    }

    public function sokaklar(int $mahalle_id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->adresService->uavtSokakListesiGetir($mahalle_id)
        ]);
    }

    public function binalar(int $sokak_id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->adresService->uavtBinaListesiGetir($sokak_id)
        ]);
    }

    public function daireler(int $bina_id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->adresService->uavtDaireListesiGetir($bina_id)
        ]);
    }
}
