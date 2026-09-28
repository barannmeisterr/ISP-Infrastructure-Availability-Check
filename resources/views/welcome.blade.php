@extends('layouts.app')

@section('content')
<section class="py-28">
    <div class="max-w-6xl mx-auto text-center px-6">


        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            İnternet Altyapı Hizmetleri
        </h1>



        <p class="text-gray-600 text-lg max-w-3xl mx-auto">
            IssAltyapı ile altyapı kontrollerinizi detaylı olarak gerçekleştirebilirsiniz.
            İnternet hizmeti alabileceğiniz firmaları görüntüleyebilirsiniz ve yüzlerce paket arasında size en uygun olan pakete başvurabilirsiniz.
        </p>

    </div>
</section>
<!-- İSTATİSTİKLER -->
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-6">

        <div
            class="grid grid-cols-2 md:grid-cols-5 text-center
                   divide-x divide-gray-200">

            @foreach($stats as $stat)
                <div class="px-4">
                    <div class="text-3xl font-extrabold">{{ $stat['count'] }}</div>
                    <div class="text-sm text-gray-500">{{ $stat['label'] }}</div>
                </div>
            @endforeach



        </div>

    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-6">
        <!-- BAŞLIK -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
                En Popüler İnternet Hizmet Sağlayıcıları
            </h2>


        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($populer_issler as $iss)
                <div class="bg-white rounded-xl shadow-sm border p-6 text-center">

                    <!-- LOGO -->
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-4 border">
                        <div class="logo-wrapper mx-auto mb-4">
                            <img
                                src="{{ $iss['logo'] }}"
                                alt="{{ $iss['name'] }}"
                                class="logo-img"
                            >
                        </div>

                    </div>

                    <!-- İSİM -->
                    <h2 class="text-xl font-bold mb-1">
                        {{ $iss['name'] }}
                    </h2>

                    <p class="text-sm text-gray-500 mb-2">
                        İnternet Hizmet Sağlayıcısı
                    </p>

                    <!-- HİZMETLER -->
                    <p class="text-sm text-gray-700 mb-2">
                        {{ implode(', ', $iss['services']) }} Altyapı
                    </p>

                    <!-- KONUM -->
                    <p class="text-sm text-gray-500 mb-4">
                        📍 {{ $iss['location'] }}
                    </p>

                    <!-- BUTON -->
                    <a
                        href="/internet-saglayicilari/{{ $iss['slug'] }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition"
                    >
                        Profili Görüntüle
                    </a>

                </div>
            @endforeach

        </div>

    </div>
</section>

<!-- POPÜLER PAKETLER -->
<section class="bg-white-50 py-24">

    <div class="max-w-7xl mx-auto px-6">

        <!-- BAŞLIK -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
                Popüler İnternet Paketleri
            </h2>
            <p class="text-gray-600 max-w-3xl mx-auto">
                Farklı internet servis sağlayıcılarının en çok tercih edilen
                paketlerini karşılaştırarak size en uygun seçeneği bulun.
            </p>
        </div>

        <div class="relative">

            <!-- SOL OK -->
            <button id="prevBtn"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10
                           bg-white shadow-xl rounded-full w-11 h-11
                           flex items-center justify-center text-3xl">
                ‹
            </button>

            <!-- SAĞ OK -->
            <button id="nextBtn"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10
                           bg-white shadow-xl rounded-full w-11 h-11
                           flex items-center justify-center text-3xl">
                ›
            </button>

            <!-- SLIDER -->
            <div id="packageSlider"
                 class="flex gap-6 overflow-x-auto scroll-smooth px-14 pb-4 scrollbar-hide">

                @foreach($populer_paketler as $package)
                    <div class="min-w-[340px]">

                        <div class="bg-white rounded-3xl shadow-md
                                    hover:shadow-xl transition
                                    border-t-4
                                  {{ $package['xdsltype'] === 7 ? 'border-indigo-600' : 'border-gray-300' }}">

                            <!-- BAŞLIK -->
                            <div class="p-6 text-center">
                                <h4 class="text-xl font-bold mb-1">
                                    {{ $package['title'] }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ $package['provider'] }} • {{ [1 => 'ADSL', 6 => 'VDSL', 7 => 'FIBER', ][$package['xdsltype']] ?? 'Bilinmiyor' }}
                                </p>
                            </div>

                            <!-- FİYAT -->
                            <div class="bg-indigo-50 py-6 text-center">
                                <span class="text-4xl font-extrabold text-indigo-600">
                                    {{ $package['price'] }}
                                </span>
                                <span class="text-gray-600"> TL / Ay</span>
                            </div>

                            <!-- ÖZELLİKLER -->
                            <div class="p-6 text-sm space-y-2 text-gray-700">
                                <div>⬇️ {{ $package['download'] .' Mbps' }} / ⬆️ {{ $package['upload'] .' Mbps' }}</div>
                                <div>{{ $package['commitment'] ? '🔒 Taahhütlü İnternet' : '🔓 Taahhütsüz İnternet' }}</div>
                                <div>{{ $package['quota'] ? '📊 Kotalı İnternet' : '♾️ Kotasız İnternet' }}</div>
                                <div>⚡ Ping: {{ $package['ping'] }}</div>
                            </div>

                            <!-- CTA -->
                            <div class="p-6 text-center">
                                <a href="/paket/{{ $package['id'] }}"
                                   class="inline-block bg-indigo-600 text-white
                                          px-6 py-3 rounded-xl font-semibold
                                          hover:bg-indigo-700 transition">
                                    Paketi İncele
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
</section>
@endsection

@push('styles')
<style>
    .logo-wrapper {
        width: 128px;
        height: 128px;
        border-radius: 9999px;
        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: center;

        background-color: #ffffff;
        border: 1px solid #e5e7eb;
    }

    .logo-img {
        max-width: 80%;
        max-height: 80%;

        width: auto;
        height: auto;

        object-fit: contain;
    }


</style>
@endpush

@push('scripts')
<script>
    const slider = document.getElementById('packageSlider');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    const scrollAmount = 360; // 1 kart genişliği

    nextBtn.addEventListener('click', () => {
        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    prevBtn.addEventListener('click', () => {
        slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
</script>
@endpush
