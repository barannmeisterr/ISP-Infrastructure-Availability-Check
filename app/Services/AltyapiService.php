<?php
/**
Author:Arda Baran
*/
namespace App\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
class AltyapiService{

    public function getFiberSpeedByFTTX1GBValue(int $fttx1gbValue): int
    {
        switch ($fttx1gbValue) {
            case 1:
                return 1000;

            case -2:
                return 100;

            default:
                return -1;
        }
    }
    public function getVarmiYokmu(int $val): string
    {
        return match ($val) {
            1 => 'Var',
            0 => 'Yok',
            default => 'Yok',
        };
    }
    public function getAdslVdslHizmetVarMi(string $santralHizmetVarMi,string $bosPortVarMi) : bool{
        if($santralHizmetVarMi === 'Var' && $bosPortVarMi === 'Var'){
            return true;
        }else{
            return false;
        }
    }
    public function flag(array $mapped, string $key): string
    {
        if (!isset($mapped[$key]) || !is_numeric($mapped[$key])) {
            return 'Yok';
        }

        return $this->getVarmiYokmu((int)$mapped[$key]);
    }
    private function mapFlexList(array $flexList): array
    {
        $mapped = [];

        foreach ($flexList as $row) {
            if (isset($row['name'], $row['value'])) {
                $mapped[$row['name']] = $row['value'];
            }
        }

        return $mapped;
    }

    public function getAdslVdslSpeed(int $dslmxspd, int $ipvmxspd, int $nmsmax): int {

        $values = [$dslmxspd, $ipvmxspd, $nmsmax];
        $values = array_filter($values, fn ($v) => $v > 0);
        if (empty($values)) {
            return 0;
        }
        $minKbps = min($values);
        return (int) ceil($minKbps / 1000);
    }

    public function fiberAltyapiSorgulama(int $bbk): array
    {
        $client = new Client([
            'base_uri' => 'https://ss',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/controlService', [
                'headers' => [
                    'X-HTTP-Authorization' => 'ss',
                    'Authorization'       => 'Bearer ss',
                    'Accept'              => 'application/json',
                ],
                'json' => [
                    'key' => $bbk,
                    'xdsltype' => 7,
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            if (
                !isset($json['hataKod']) ||
                (string)$json['hataKod'] !== '100'
            ) {
                return [
                    'fiber_var_mi' => false,
                    'santral_hizmet'=> 'Yok',
                    'bos_port'=> 'Yok',
                    'hiz'=> 0,
                    'santral_adi'=> 'Bulunamadı',
                    'santral_mudurluk_adi'=> 'Bulunamadı',
                    'santral_mesafe'=> 0,
                ];
            }

            $mapped = $this->mapFlexList($json['flexList']['flexList'] ?? []);

            return [
                'fiber_var_mi' => true,

                'santral_hizmet' =>
                    $this->flag($mapped, 'SNTRLHZMT'),

                'bos_port' =>
                    $this->flag($mapped, 'BSPRT'),

                'hiz' =>
                    $this->getFiberSpeedByFTTX1GBValue(
                        (int)($mapped['FTTX1GB'] ?? 0)
                    ),

                'santral_adi' =>
                    $mapped['SNTRLAD'] ?? 'Bulunamadı',

                'santral_mudurluk_adi' =>
                    $mapped['SNTRLMDA'] ?? 'Bulunamadı',

                'santral_mesafe' =>
                    is_numeric($mapped['SNTRLMSF'] ?? null)
                        ? (int)$mapped['SNTRLMSF']
                        : 0,
            ];

        } catch (GuzzleException $e) {
            logger()->error('Fiber Sorgulama Hatası!', [
                'key' => $bbk,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    public function vdslAltyapiSorgulama(int $bbk): array
    {
        $client = new Client([
            'base_uri' => 'https://ss',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/controlService', [
                'headers' => [
                    'X-HTTP-Authorization' => 'ss',
                    'Authorization'       => 'Bearer ss',
                    'Accept'              => 'application/json',
                ],
                'json' => [
                    'key' => $bbk,
                    'xdsltype' => 6, // VDSL
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            if (
                !isset($json['hataKod']) ||
                (string)$json['hataKod'] !== '100'
            ) {
                return [
                    'vdsl_var_mi' => false,
                    'santral_hizmet'=> 'Yok',
                    'bos_port'=> 'Yok',
                    'hiz'=> 0,
                    'santral_adi'=> 'Bulunamadı',
                    'santral_mudurluk_adi'=> 'Bulunamadı',
                    'santral_mesafe'=> 0,
                ];
            }

            $mapped = $this->mapFlexList($json['flexList']['flexList'] ?? []);

            return [
                'vdsl_var_mi' =>  $this->getAdslVdslHizmetVarMi($this->flag($mapped, 'SNTRLHZMT'),$this->flag($mapped, 'BSPRT')),

                'santral_hizmet' =>
                    $this->flag($mapped, 'SNTRLHZMT'),

                'bos_port' =>
                    $this->flag($mapped, 'BSPRT'),

                'hiz' =>
                    $this->getAdslVdslSpeed(
                        is_numeric($mapped['DSLMXSPD'] ?? null) ? (int)$mapped['DSLMXSPD'] : 0,
                        is_numeric($mapped['IPVMXSPD'] ?? null) ? (int)$mapped['IPVMXSPD'] : 0,
                        is_numeric($mapped['NMSMAX'] ?? null)   ? (int)$mapped['NMSMAX']   : 0
                    ),

                'santral_adi' =>
                    $mapped['SNTRLAD'] ?? 'Bulunamadı',

                'santral_mudurluk_adi' =>
                    $mapped['SNTRLMDA'] ?? 'Bulunamadı',

                'santral_mesafe' =>
                    is_numeric($mapped['SNTRLMSF'] ?? null)
                        ? (int)$mapped['SNTRLMSF']
                        : 0,
            ];

        } catch (GuzzleException $e) {
            logger()->error('Vdsl Sorgulama Hatası!', [
                'key' => $bbk,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    public function adslAltyapiSorgulama(int $bbk): array
    {
        $client = new Client([
            'base_uri' => 'https://ss',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/controlService', [
                'headers' => [
                    'X-HTTP-Authorization' => 'ss',
                    'Authorization'       => 'Bearer ss',
                    'Accept'              => 'application/json',
                ],
                'json' => [
                    'key' => $bbk,
                    'xdsltype' => 1, // ADSL
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            if (
                !isset($json['hataKod']) ||
                (string)$json['hataKod'] !== '100'
            ) {
                return [
                    'adsl_var_mi' => false,
                    'santral_hizmet'=> 'Yok',
                    'bos_port'=> 'Yok',
                    'hiz'=> 0,
                    'santral_adi'=> 'Bulunamadı',
                    'santral_mudurluk_adi'=> 'Bulunamadı',
                    'santral_mesafe'=> 0,
                ];
            }

            $mapped = $this->mapFlexList($json['flexList']['flexList'] ?? []);

            return [
                'adsl_var_mi' =>  $this->getAdslVdslHizmetVarMi($this->flag($mapped, 'SNTRLHZMT'),$this->flag($mapped, 'BSPRT')),

                'santral_hizmet' =>
                    $this->flag($mapped, 'SNTRLHZMT'),

                'bos_port' =>
                    $this->flag($mapped, 'BSPRT'),

                'hiz' =>
                    $this->getAdslVdslSpeed(
                        is_numeric($mapped['DSLMXSPD'] ?? null) ? (int)$mapped['DSLMXSPD'] : 0,
                        is_numeric($mapped['IPVMXSPD'] ?? null) ? (int)$mapped['IPVMXSPD'] : 0,
                        is_numeric($mapped['NMSMAX'] ?? null)   ? (int)$mapped['NMSMAX']   : 0
                    ),

                'santral_adi' =>
                    $mapped['SNTRLAD'] ?? 'Bulunamadı',

                'santral_mudurluk_adi' =>
                    $mapped['SNTRLMDA'] ?? 'Bulunamadı',

                'santral_mesafe' =>
                    is_numeric($mapped['SNTRLMSF'] ?? null)
                        ? (int)$mapped['SNTRLMSF']
                        : 0,
            ];

        } catch (GuzzleException $e) {
            logger()->error('Adsl Sorgulama Hatası!', [
                'key' => $bbk,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

}
