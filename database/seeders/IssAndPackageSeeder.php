<?php

namespace Database\Seeders;

use App\Models\HomeHighlightedPackage;
use App\Models\HomeHighlightedProvider;
use App\Models\HomeStat;
use App\Models\IssProvider;
use App\Models\IssServiceArea;
use App\Models\Package;
use App\Models\PackageArea;
use Illuminate\Database\Seeder;

class IssAndPackageSeeder extends Seeder
{
    public function run(): void
    {
        // Temizle (foreign key constraint'ler nedeniyle doğru sırayla sil)

        HomeHighlightedPackage::query()->delete();
        HomeHighlightedProvider::query()->delete();
        PackageArea::query()->delete();
        Package::query()->delete();
        IssServiceArea::query()->delete();
        IssProvider::query()->delete();
        HomeStat::query()->delete();

        // ISS Sağlayıcılar
        $durunet = IssProvider::create([
            'name' => 'Durunet',
            'slug' => 'durunet',
            'logo_path' => 'iss-company-logos/durunet.png',
            'location' => 'Antalya',
            'services' => json_encode(['ADSL', 'VDSL', 'FIBER']),
            'company_info' => 'DuruNet, teknolojik altyapıyı sürekli olarak güncelleyen ve ileri düzeydeki ekipmanları kullanarak müşterilerine yüksek performanslı internet hizmetleri sunmaktadır. Şirketin güçlü ve istikrarlı ağ altyapısı, kesintisiz bağlantı imkânı sağlayarak işletmelerin verimliliğini artırmayı hedefler. Bununla birlikte, DuruNet, işletmelerin verilerini güvenli bir şekilde yönetmelerini sağlayan çeşitli bilişim çözümleri sunmaktadır. Veri güvenliği ve gizlilik konularına büyük önem veren şirket, ileri düzeydeki güvenlik önlemleriyle müşterilerinin verilerini koruma altına alır ve güvenilir bir veri yönetimi sağlar. Müşteri odaklı bir yaklaşımla hareket eder ve müşteri memnuniyetini en üst düzeyde tutmayı amaçlar. Uzman ekip, müşterilere ihtiyaçlarına uygun çözümler sunmak ve teknik destek sağlamak için sürekli olarak çalışır. Şirket, müşterilerinin iş süreçlerini optimize etmelerine ve rekabet avantajı elde etmelerine yardımcı olmak için teknolojik yenilikleri takip eder ve bunları uygulamaya koyar.',
            'cagrimerkezi' => '+90 850 840 1728',
            'whatsapp_no' => '+90 850 840 1728',
            'fax' => '+90 242 731 00 50',
            'email' => 'info@durunet.com.tr',
            'website' => 'www.durunet.com.tr',
            'unvan' => 'Duru İnternet Ve Bilişim Teknolojileri Sanayi Ticaret Limited Şirketi',
            'address' => 'Y.Hisar Mah. 7001 Sk. Bına No:14 Daıre:3 Manavgat/Antalya',
        ]);

        foreach (['Antalya', 'Mersin', 'Samsun', 'Balıkesir', 'Bursa'] as $city) {
            IssServiceArea::create([
                'iss_provider_id' => $durunet->id,
                'city' => $city,
            ]);
        }

        $vivanet = IssProvider::create([
            'name' => 'Vivanet',
            'slug' => 'vivanet',
            'logo_path' => 'iss-company-logos/vivanet.png',
            'location' => 'Tekirdağ',
            'services' => json_encode(['FIBER']),
            'company_info' => 'Vivanet, internet kullanıcılarına yüksek hızda ve kesintisiz bağlantı sunarak kaliteli hizmet anlayışını benimseyen bir servis sağlayıcıdır. Bireysel ve kurumsal müşterilere hitap eden Vivanet, her türlü internet ihtiyacına uygun çözümler sunar.Müşteri memnuniyeti Vivanet için bir önceliktir. Bu nedenle 7/24 ulaşılabilir teknik destek ekibi ile müşterilerinin yanında olur. Yaşanan sorunlara hızlıca çözüm üreterek kullanıcıların bağlantı deneyiminde aksaklık yaşamasını engeller. Kurulum süreçlerinde sağladığı kolaylık ve hız ile öne çıkan Vivanet, yeni kullanıcıların internet hizmetine kısa sürede geçmesini sağlar.Vivanet’in sunduğu esnek paket seçenekleri sayesinde kullanıcıların ihtiyaçlarına ve bütçelerine en uygun Vivanet internet paketleri seçilebilir. Yüksek hizmet kalitesi, teknik destek ve kesintisiz bağlantı güvencesi ile Vivanet, internet kullanıcılarına güvenilir bir çözüm sunmayı hedefler.',
            'cagrimerkezi' => '+90 850 471 8080',
            'whatsapp_no' => '+90 0850 471 8080',
            'fax' => '+90 282 359 53 52',
            'email' => 'iletisim@vivanet.com.tr',
            'website' => 'www.vivanet.tr',
            'unvan' => 'Viva İnternet Limited Şirketi',
            'address' => 'Camikebir Mh. Hasat Sk. N:8 D:3 Şarköy / Tekirdağ',
        ]);

        foreach (['Tekirdağ', 'Edirne', 'Çanakkale', 'İstanbul', 'Kırklareli'] as $city) {
            IssServiceArea::create([
                'iss_provider_id' => $vivanet->id,
                'city' => $city,
            ]);
        }

        $turkcell = IssProvider::create([
            'name' => 'Turkcell',
            'slug' => 'turkcell',
            'logo_path' => 'iss-company-logos/turkcell.png',
            'location' => 'İstanbul',
            'services' => json_encode(['FIBER', 'VDSL']),
            'company_info' => 'Turkcell, Türkiye’de kurulan entegre iletişim ve teknoloji şirketidir. Birey ve kurumlara, sabit şebeke ve mobil üzerinden data, ses ve TV hizmetleri sağlar. Turkcell, Türkiye’nin ilk GSM ağını 1994 yılında kurdu. 1998’de T.C. Ulaştırma Bakanlığı ile 25 senelik GSM lisans anlaşması imzaladı. Buna bağlı olarak ses, data ve veri iletişim hizmetlerinin çeşitliliği ve kalitesi, müşteri sayısını artırdı.Türkiye dışındaki yatırımlarıyla da faaliyet gösteren Turkcell; Azerbaycan, Gürcistan, Kazakistan ve Moldova pazarında mobil operasyonlarını sürdürür. “KKTCell”, %100 Turkcell iştirakı olup KKTC Telekomünikasyon Dairesi’yle gelir paylaşımı anlaşmasına bağlı kalınarak faaliyet gösterir. Aynı zamanda Turkcell’in Ukrayna’da %100 oranda hisseye sahip olduğu “Lifecell”, 2005 senesinde GSM hizmetine başladı. Turkcell, dünya genelinde HSPA+ teknolojisini kullanmak konusunda ilklere imza atmış bir operatördür. Bununla birlikte dünyada ilk kez 3G şebekesi dahilinde; 63,3 Mbps’e kadar veri indirme hızının yanında, 11,5 Mbps’e varan yükleme hızı ile hizmet verebilmektedir. Turkcell, evlere 1000 Mbps’e varan hızda fiber internet imkânı sunan ilk telekomünikasyon operatörüdür. Aynı zamanda sunduğu tüm bu fırsatlar ve daha fazlası hakkında bilgi sahibi olmak isteyen kişilere Turkcell müşteri hizmetleri yardımcı olmaktadır.  Firmanın kesintisiz hizmet sunan çağrı merkezi departmanına, istenilen her an ulaşım sağlamak mümkündür.',
            'cagrimerkezi' => '+90 532 532 00 00',
            'whatsapp_no' => '+90 0850 471 8080',
            'fax' => '+90 212 313 10 10',
            'email' => 'iletisim@turkcell.com.tr',
            'website' => 'www.turkcell.com.tr',
            'unvan' => 'Turkcell İletişim Hizmetleri Anonim Şirketi',
            'address' => 'Aydınevler Mah. İsmet İnönü Cad. No:20 Maltepe - İstanbul',
        ]);

        // Turkcell için sadece birkaç şehir ekleyelim
        foreach (['İstanbul', 'Ankara', 'İzmir'] as $city) {
            IssServiceArea::create([
                'iss_provider_id' => $turkcell->id,
                'city' => $city,
            ]);
        }

        // Paketler
        $p1 = Package::create([
            'iss_provider_id' => $durunet->id,
            'title' => 'Tek Paket 100 Mbps VDSL',
            'xdsltype' => 6,
            'download' => 100,
            'upload' => 15,
            'price' => 100,
            'commitment' => false,
            'quota' => false,
            'ping' => 'Düşük',
            'description' => 'Radyolink altyapısıyla sağlanan sınırsız ve kotasız 13 Mbps internet hızı sunan paket.',
        ]);


        $p2 = Package::create([
            'iss_provider_id' => $vivanet->id,
            'title' => 'Fiber 500 Mbps',
            'xdsltype' => 7,
            'download' => 500,
            'upload' => 100,
            'price' => 250,
            'commitment' => true,
            'commitment_month' => 24,
            'quota' => false,
            'ping' => 'Çok Düşük',
            'description' => 'Vivanet’in 35 Mbps internet paketi, fiber altyapı ile sunulan yüksek hızlı ve kesintisiz bir internet deneyimi sağlar.',
        ]);

        $p3 = Package::create([
            'iss_provider_id' => $turkcell->id,
            'title' => 'ADSL 46 Mbps',
            'xdsltype' => 1,
            'download' => 46,
            'upload' => 1,
            'price' => 25,
            'commitment' => false,
            'quota' => true,
            'ping' => 'Orta',
            'description' => 'Uygun fiyatlı ADSL paketi.',
        ]);

        PackageArea::create([
            'package_id' => $p1->id,
            'city' => 'Antalya',
            'il_id' => 7,
            'ilce_id' => 2038,
            'mahalle_id' => 2351,
            'csbm_id' => 842580,
            'bina_id' => 25314849,
        ]);

        PackageArea::create([
            'package_id' => $p1->id,
            'city' => 'Muğla',
            'il_id' => null,
            'ilce_id' => null,
            'mahalle_id' => null,
            'csbm_id' => null,
            'bina_id' => null,
        ]);

        PackageArea::create([
            'package_id' => $p1->id,
            'city' => 'Konya',
            'il_id' => null,
            'ilce_id' => null,
            'mahalle_id' => null,
            'csbm_id' => null,
            'bina_id' => null,
        ]);



        PackageArea::create([
            'package_id' => $p1->id,
            'city' => 'Antalya',
            'il_id' => null,
            'ilce_id' => null,
            'mahalle_id' => null,
            'csbm_id' => null,
            'bina_id' => null,
        ]);
        PackageArea::create([
            'package_id' => $p2->id,
            'city' => 'Mersin',
            'il_id' => 7,
            'ilce_id' => 2038,
            'mahalle_id' => 2351,
            'csbm_id' => 842580,
            'bina_id' => 25314849,
        ]);
        PackageArea::create([
            'package_id' => $p3->id,
            'city' => 'İstanbul',
            'il_id' => 7,
            'ilce_id' => 2038,
            'mahalle_id' => 2351,
            'csbm_id' => 842580,
            'bina_id' => 25314849,
        ]);



        // Öne çıkarılan ISS ve paketler
        HomeHighlightedProvider::create([
            'iss_provider_id' => $durunet->id,
            'sort_order' => 1,
        ]);
        HomeHighlightedProvider::create([
            'iss_provider_id' => $vivanet->id,
            'sort_order' => 2,
        ]);
        HomeHighlightedProvider::create([
            'iss_provider_id' => $turkcell->id,
            'sort_order' => 3,
        ]);

        HomeHighlightedPackage::create([
            'package_id' => $p1->id,
            'sort_order' => 1,
        ]);
        HomeHighlightedPackage::create([
            'package_id' => $p2->id,
            'sort_order' => 2,
        ]);
        HomeHighlightedPackage::create([
            'package_id' => $p3->id,
            'sort_order' => 3,
        ]);

        // Ana sayfa istatistikleri
        $stats = [
            ['count' => 241, 'label' => 'İnternet Paketi', 'order' => 1],
            ['count' => 3,  'label' => 'İnternet Servis Sağlayıcı', 'order' => 2],
            ['count' => 81,  'label' => 'Şehir', 'order' => 3],
            ['count' => 4,   'label' => 'Altyapı Türü', 'order' => 4],
            ['count' => 3500,'label' => 'Memnun Müşteri', 'order' => 5],
        ];

        foreach ($stats as $stat) {
            HomeStat::create($stat);
        }
    }
}

