@extends('layouts.app')

@section('content')
<div class="pricing-table-2 bg-gray-800 py-6 md:py-12">
    <div class="container mx-auto px-4">

        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-medium text-white mb-4 md:mb-6">Altyapınıza Uygun Paketler</h1>
            <p class="text-gray-500 xl:mx-12">Yapılan kontroller sonucunda adresinizde hizmet veren internet servis sağlayıcı firmaların size sunabileceği internet paketlerini inceleyebilirsiniz. Altyapı durumunuza uygun hız seçenekleri, bağlantı türleri ve kampanyalar bu sayfada listelenmektedir.

                İhtiyacınıza göre fiber, VDSL veya ADSL paketleri arasından seçim yapabilir; taahhüt süresi, aylık ücret ve ek hizmetleri karşılaştırarak en doğru tercihi yapabilirsiniz. Sunulan paketler, mevcut altyapınız doğrultusunda erişilebilir olan en yüksek hız ve en stabil bağlantıyı sağlayacak şekilde belirlenmiştir.

                Size en uygun internet paketini seçerek başvuru sürecini hemen başlatabilir, hızlı ve kesintisiz internet deneyimine ilk adımı atabilirsiniz. </p>
        </div>

        <div class="relative mt-6 md:mt-12">

            <!-- SOL OK -->
            <button id="prevBtn"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10
               bg-white/90 hover:bg-white shadow rounded-full w-10 h-10
               flex items-center justify-center text-2xl text-gray-700">
                ‹
            </button>

            <!-- SAĞ OK -->
            <button id="nextBtn"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10
               bg-white/90 hover:bg-white shadow rounded-full w-10 h-10
               flex items-center justify-center text-2xl text-gray-700">
                ›
            </button>

            <!-- KAYDIRMA ALANI -->
            <div id="packageSlider"
                 class="pricing-plans flex gap-6 overflow-x-auto scroll-smooth
                px-12 scrollbar-hide">

                @foreach($packages as $package)
                    <div class="min-w-[320px]">

                        <div
                            class="pricing-plan border-t-4 border-solid border-white bg-white
                           text-center max-w-sm mx-auto
                           hover:border-indigo-600 transition-colors duration-300">

                            <!-- BAŞLIK -->
                            <div class="p-6 md:py-8">
                                <h4 class="font-medium leading-tight text-2xl mb-2">
                                    {{ $package['provider'] }}
                                </h4>
                                <p class="text-gray-600">
                                    {{ $package['title'] }}
                                </p>
                            </div>

                            <!-- FİYAT -->
                            <div class="pricing-amount bg-indigo-100 p-6 transition-colors duration-300">
                                <div>
                            <span class="text-4xl font-semibold">
                                {{ $package['price'] }} TL
                            </span>
                                    /Ay
                                </div>
                            </div>

                            <!-- ÖZELLİKLER -->
                            <div class="p-6">
                                <ul class="leading-loose text-sm">
                                    <li>🛜
                                        {{ [
                                            1 => 'ADSL',
                                            6 => 'VDSL',
                                            7 => 'FIBER',
                                        ][$package['xdsltype']] ?? 'Bilinmeyen' }}
                                    </li>

                                    <li>⬇️ {{ $package['download']  . ' Mbps' }} ⬆️ {{ $package['upload'] . ' Mbps' }}</li>
                                    <li>{{ $package['commitment'] ? '🔒 Taahhütlü' : '🔓 Taahhütsüz' }} internet</li>
                                    <li>{{ $package['quota'] ? '📊 Kotalı' : '♾️ Kotasız' }} internet</li>
                                    <li>⚡ Ping: {{ $package['ping'] }}</li>
                                </ul>

                                <!-- CTA -->
                                <div class="mt-6 py-4">
                                    <a href="/paket/{{ $package['id'] }}"
                                       class="bg-indigo-600 text-xl text-white py-2 px-6 rounded
                                      hover:bg-indigo-700 transition-colors duration-300 inline-block">
                                        İncele
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </div> <!-- container -->
</div> <!-- pricing-table-2 -->




    <style>
    .pricing-plan {
    &:hover {
    .pricing-amount {
    background-color: #4c51bf;
    color: #fff;
    }
    }
    }
    </style>
@endsection

@push('styles')
<style>
    .pricing-plan {
    &:hover {
    .pricing-amount {
    background-color: #4c51bf;
    color: #fff;
    }
    }
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
