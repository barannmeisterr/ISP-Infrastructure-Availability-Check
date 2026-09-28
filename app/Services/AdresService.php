<?php
/**
Author:Arda Baran
*/
namespace App\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AdresService
{

    public function uavtIlListesiGetir(): array
    {
        $client = new Client([
            'base_uri' => 'https://192.168.108.2',
            'verify'   => false, // self-signed SSL varsa
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/ilListesiGetir', [
                'headers' => [
                    'X-HTTP-Authorization' => 'c63c730d78c01161418c21550390ba7b',
                    'Authorization'       => 'Bearer c63c730d78c01161418c21550390ba7b', // gerekiyorsa
                    'Content-Type'        => 'application/json',
                    'Accept'              => 'application/json',
                ],
                'json' => new \stdClass(), // Postman'deki {} karşılığı
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            // 1️⃣ Güvenlik kontrolleri
            if (
                !isset($json['success']) ||
                $json['success'] !== true ||
                !isset($json['data']) ||
                !is_array($json['data'])
            ) {
                return [];
            }

            // 2️⃣ Map işlemi (istenen alanlar)
            return array_map(static function (array $item) {
                return [
                    'kod' => $item['kod'],
                    'ad'  => $item['ad'],
                ];
            }, $json['data']);

        } catch (GuzzleException $e) {
            // logla, exception fırlat ya da boş array dön
            logger()->error('UAVT İl Listesi Hatası', [
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }


    function uavtIlceListesiGetir(int $il_id): array
    {
        $client = new Client([
            'base_uri' => 'https://192.168.108.2',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/ilceListesiGetir', [
                'headers' => [
                    'X-HTTP-Authorization' => 'c63c730d78c01161418c21550390ba7b',
                    'Authorization'       => 'Bearer c63c730d78c01161418c21550390ba7b',
                    'Accept'              => 'application/json',
                ],

                // ✅ ASIL OLAY BURASI
                'json' => [
                    'il_id' => $il_id,
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            // 1️⃣ API doğrulama
            if (
                !isset($json['success']) ||
                $json['success'] !== true ||
                !isset($json['data']) ||
                !is_array($json['data'])
            ) {
                return [];
            }

            // 2️⃣ Sadece gereken alanları çıkar
            return array_map(static function (array $item) {
                return [
                    'kod' => $item['kod'],
                    'ad'  => $item['ad'],
                ];
            }, $json['data']);

        } catch (GuzzleException $e) {
            logger()->error('UAVT İlçe Listesi Hatası', [
                'il_id' => $il_id,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    function uavtBucakListesiGetir(int $ilce_id): array
    {
        $client = new Client([
            'base_uri' => 'https://192.168.108.2',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/bucakListesiGetir', [
                'headers' => [
                    'X-HTTP-Authorization' => 'c63c730d78c01161418c21550390ba7b',
                    'Authorization'       => 'Bearer c63c730d78c01161418c21550390ba7b',
                    'Accept'              => 'application/json',
                ],

                // ✅ ASIL OLAY BURASI
                'json' => [
                    'ilce_id' => $ilce_id,
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            // 1️⃣ API doğrulama
            if (
                !isset($json['success']) ||
                $json['success'] !== true ||
                !isset($json['data']) ||
                !is_array($json['data'])
            ) {
                return [];
            }

            // 2️⃣ Sadece gereken alanları çıkar
            return array_map(static function (array $item) {
                return [
                    'kod' => $item['kod'],
                    'ad'  => $item['ad'],
                ];
            }, $json['data']);

        } catch (GuzzleException $e) {
            logger()->error('UAVT Bucak Listesi Hatası', [
                'ilce_id' => $ilce_id,
                'error' => $e->getMessage(),
            ]);

            return [];
        }

    }

    function uavtMahalleListesiGetir(int $bucak_id): array
    {
        $client = new Client([
            'base_uri' => 'https://192.168.108.2',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/mahalleListesiGetir', [
                'headers' => [
                    'X-HTTP-Authorization' => 'c63c730d78c01161418c21550390ba7b',
                    'Authorization'       => 'Bearer c63c730d78c01161418c21550390ba7b',
                    'Accept'              => 'application/json',
                ],

                // ✅ ASIL OLAY BURASI
                'json' => [
                    'bucak_id' => $bucak_id,
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            // 1️⃣ API doğrulama
            if (
                !isset($json['success']) ||
                $json['success'] !== true ||
                !isset($json['data']) ||
                !is_array($json['data'])
            ) {
                return [];
            }

            // 2️⃣ Sadece gereken alanları çıkar
            return array_map(static function (array $item) {
                return [
                    'kod' => $item['kod'],
                    'ad'  => $item['ad'],
                ];
            }, $json['data']);

        } catch (GuzzleException $e) {
            logger()->error('UAVT Mahalle Listesi Hatası', [
                'bucak_id' => $bucak_id,
                'error' => $e->getMessage(),
            ]);

            return [];
        }

    }

    function uavtSokakListesiGetir(int $mahalle_id): array
    {
        $client = new Client([
            'base_uri' => 'https://192.168.108.2',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/sokakListesiGetir', [
                'headers' => [
                    'X-HTTP-Authorization' => 'c63c730d78c01161418c21550390ba7b',
                    'Authorization'       => 'Bearer c63c730d78c01161418c21550390ba7b',
                    'Accept'              => 'application/json',
                ],

                // ✅ ASIL OLAY BURASI
                'json' => [
                    'mahalle_id' => $mahalle_id,
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            // 1️⃣ API doğrulama
            if (
                !isset($json['success']) ||
                $json['success'] !== true ||
                !isset($json['data']) ||
                !is_array($json['data'])
            ) {
                return [];
            }

            // 2️⃣ Sadece gereken alanları çıkar
            return array_map(static function (array $item) {
                return [
                    'kod' => $item['kod'],
                    'ad'  => $item['ad'],
                ];
            }, $json['data']);

        } catch (GuzzleException $e) {
            logger()->error('UAVT Sokak Listesi Hatası', [
                'mahalle_id' => $mahalle_id,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    function uavtBinaListesiGetir(int $sokak_id): array
    {
        $client = new Client([
            'base_uri' => 'https://192.168.108.2',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/binaListesiGetir', [
                'headers' => [
                    'X-HTTP-Authorization' => 'c63c730d78c01161418c21550390ba7b',
                    'Authorization'       => 'Bearer c63c730d78c01161418c21550390ba7b',
                    'Accept'              => 'application/json',
                ],

                // ✅ ASIL OLAY BURASI
                'json' => [
                    'sokak_id' => $sokak_id,
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            // 1️⃣ API doğrulama
            if (
                !isset($json['success']) ||
                $json['success'] !== true ||
                !isset($json['data']) ||
                !is_array($json['data'])
            ) {
                return [];
            }

            // 2️⃣ Sadece gereken alanları çıkar
            return array_map(static function (array $item) {
                return [
                    'kod' => $item['kod'],
                    'ad'  => $item['ad'],
                ];
            }, $json['data']);

        } catch (GuzzleException $e) {
            logger()->error('UAVT Bina Listesi Hatası', [
                'sokak_id' => $sokak_id,
                'error' => $e->getMessage(),
            ]);

            return [];
        }

    }

    function uavtDaireListesiGetir(int $bina_id): array
    {
        $client = new Client([
            'base_uri' => 'https://192.168.108.2',
            'verify'   => false,
            'timeout'  => 10,
        ]);

        try {
            $response = $client->post('/api/uavt_adres/daireListesiGetir', [
                'headers' => [
                    'X-HTTP-Authorization' => 'c63c730d78c01161418c21550390ba7b',
                    'Authorization'       => 'Bearer c63c730d78c01161418c21550390ba7b',
                    'Accept'              => 'application/json',
                ],

                // ✅ ASIL OLAY BURASI
                'json' => [
                    'bina_id' => $bina_id,
                ],
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            // 1️⃣ API doğrulama
            if (
                !isset($json['success']) ||
                $json['success'] !== true ||
                !isset($json['data']) ||
                !is_array($json['data'])
            ) {
                return [];
            }

            // 2️⃣ Sadece gereken alanları çıkar
            return array_map(static function (array $item) {
                return [
                    'kod' => $item['kod'],
                    'ad'  => $item['ad'],
                ];
            }, $json['data']);

        } catch (GuzzleException $e) {
            logger()->error('UAVT Daire Listesi Hatası', [
                'bina_id' => $bina_id,
                'error' => $e->getMessage(),
            ]);

            return [];
        }

    }
}
