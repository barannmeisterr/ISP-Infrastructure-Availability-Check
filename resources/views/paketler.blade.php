@extends('layouts.app')

@section('content')
<!-- CONTENT -->
<main class="max-w-7xl mx-auto px-6 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-10">

        <!-- SIDEBAR -->
        <aside class="space-y-8 sticky top-24 self-start">

            <!-- Altyapı -->
            <div>
                <h3 class="font-semibold mb-3">Altyapı</h3>
                <div class="space-y-2 text-sm">

                    <label class="flex gap-2">
                        <input
                            type="checkbox"
                            name="altyapi[]"
                            value="ADSL"
                            {{ in_array('ADSL', request('altyapi', [])) ? 'checked' : '' }}
                        >
                        ADSL
                    </label>

                    <label class="flex gap-2">
                        <input
                            type="checkbox"
                            name="altyapi[]"
                            value="VDSL"
                            {{ in_array('VDSL', request('altyapi', [])) ? 'checked' : '' }}
                        >
                        VDSL
                    </label>

                    <label class="flex gap-2">
                        <input
                            type="checkbox"
                            name="altyapi[]"
                            value="FIBER"
                            {{ in_array('FIBER', request('altyapi', [])) ? 'checked' : '' }}
                        >
                        FİBER
                    </label>

                </div>
            </div>


            <!-- ISS -->
            <div>
                <h3 class="font-semibold mb-3">İnternet Servis Sağlayıcı</h3>

                <div class="max-h-48 overflow-y-auto space-y-2 text-sm pr-1">
                    @foreach($issler as $iss)
                        <label class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="iss[]"
                                value="{{ $iss }}"
                                {{ in_array($iss, request('iss', [])) ? 'checked' : '' }}
                            >
                            {{ $iss }}
                        </label>
                    @endforeach
                </div>
            </div>


            <!-- Fiyat -->
            <!-- FİYAT ARALIĞI -->
            <div class="space-y-3" id="price-range">

                <h3 class="font-semibold">Ücret</h3>

                <!-- BALONCUKLAR -->
                <div class="flex justify-between px-2 text-sm font-semibold">
        <span id="minBubble"
              class="bg-purple-600 text-white px-3 py-1 rounded-lg">
            0
        </span>

                    <span id="maxBubble"
                          class="bg-purple-600 text-white px-3 py-1 rounded-lg">
            10000
        </span>
                </div>

                <!-- SLIDER -->
                <div class="relative h-8">

                    <!-- TRACK -->
                    <div class="absolute top-1/2 w-full h-1 bg-gray-200 rounded"></div>

                    <!-- AKTİF ARALIK -->
                    <div id="rangeFill"
                         class="absolute top-1/2 h-1 bg-purple-500 rounded"></div>

                    <!-- MIN -->
                    <input
                        id="minRange"
                        type="range"
                        min="0"
                        max="10000"
                        value="0"
                        step="50"
                        class="range-input absolute w-full bg-transparent"
                    >

                    <!-- MAX -->
                    <input
                        id="maxRange"
                        type="range"
                        min="0"
                        max="10000"
                        value="10000"
                        step="50"
                        class="range-input absolute w-full bg-transparent"
                    >
                </div>

                <!-- BACKEND -->
                <input type="hidden" name="min_price" id="minPriceInput" value="500">
                <input type="hidden" name="max_price" id="maxPriceInput" value="2000">

            </div>

            <!-- İNDİRME HIZI -->
            <div class="space-y-3" id="download-range">

                <h3 class="font-semibold">İndirme Hızı</h3>

                <div class="flex justify-between px-2 text-sm font-semibold">
        <span id="minDownloadBubble"
              class="bg-blue-600 text-white px-3 py-1 rounded-lg">0 Mbps</span>

                    <span id="maxDownloadBubble"
                          class="bg-blue-600 text-white px-3 py-1 rounded-lg">1000 Mbps</span>
                </div>

                <div class="relative h-8">

                    <div class="absolute top-1/2 w-full h-1 bg-gray-200 rounded"></div>

                    <div id="downloadRangeFill"
                         class="absolute top-1/2 h-1 bg-blue-500 rounded"></div>

                    <input
                        id="minDownloadRange"
                        type="range"
                        min="0"
                        max="1000"
                        value="0"
                        step="10"
                        class="range-input absolute w-full bg-transparent"
                    >

                    <input
                        id="maxDownloadRange"
                        type="range"
                        min="0"
                        max="1000"
                        value="1000"
                        step="10"
                        class="range-input absolute w-full bg-transparent"
                    >
                </div>

                <input type="hidden" name="download_min" id="downloadMinInput" value="0">
                <input type="hidden" name="download_max" id="downloadMaxInput" value="1000">
            </div>

            <!-- YÜKLEME HIZI -->
            <div class="space-y-3" id="upload-range">

                <h3 class="font-semibold">Yükleme Hızı</h3>

                <!-- BALONCUKLAR -->
                <div class="flex justify-between px-2 text-sm font-semibold">
        <span id="minUploadBubble"
              class="bg-green-600 text-white px-3 py-1 rounded-lg">
            0 Mbps
        </span>

                    <span id="maxUploadBubble"
                          class="bg-green-600 text-white px-3 py-1 rounded-lg">
            1000 Mbps
        </span>
                </div>

                <!-- SLIDER -->
                <div class="relative h-8">

                    <!-- TRACK -->
                    <div class="absolute top-1/2 w-full h-1 bg-gray-200 rounded"></div>

                    <!-- AKTİF ARALIK -->
                    <div id="uploadRangeFill"
                         class="absolute top-1/2 h-1 bg-green-500 rounded"></div>

                    <!-- MIN -->
                    <input
                        id="minUploadRange"
                        type="range"
                        min="0"
                        max="1000"
                        value="0"
                        step="10"
                        class="range-input absolute w-full bg-transparent"
                    >

                    <!-- MAX -->
                    <input
                        id="maxUploadRange"
                        type="range"
                        min="0"
                        max="1000"
                        value="1000"
                        step="10"
                        class="range-input absolute w-full bg-transparent"
                    >
                </div>

                <!-- BACKEND -->
                <input type="hidden" name="upload_min" id="uploadMinInput" value="0">
                <input type="hidden" name="upload_max" id="uploadMaxInput" value="1000">

            </div>

            <!-- TAAHHÜT -->
            <div class="space-y-2">
                <h3 class="font-semibold">Taahhüt</h3>

                <select
                    name="commitment"
                    id="commitmentSelect"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                    <option value="2">Tümü</option>
                    <option value="1">Var</option>
                    <option value="0">Yok</option>
                </select>
            </div>
            <!-- KOTA -->
            <div class="space-y-2">
                <h3 class="font-semibold">Kota</h3>

                <select
                    name="quota"
                    id="quotaSelect"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                    <option value="2">Tümü</option>
                    <option value="1">Kotalı</option>
                    <option value="0">Kotasız</option>
                </select>
            </div>

            <!-- ARA BUTONU -->
            <div class="pt-4">
                <button
                    id="searchBtn"
                    type="button"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white
               font-semibold py-3 rounded-xl transition"
                >
                    Ara
                </button>
            </div>


        </aside>

        <!-- PAKETLER -->
        <section>



            <!-- GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($packages as $package)

                    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">

                        <!-- GÖRSEL ALANI -->
                        <div class="aspect-[3/4] bg-white flex items-center justify-center overflow-hidden">
                            <img
                                src="{{ $package['logo'] }}"
                                alt="{{ $package['title'] }}"
                                class="max-w-full max-h-full object-contain"
                            >
                        </div>


                        <!-- İÇERİK -->
                        <div class="p-4 space-y-2">

                            <h3 class="font-semibold text-sm">
                                {{ $package['provider'] }} – {{ $package['title'] }}
                            </h3>

                            <p class="text-xs text-gray-500">
                                🛜    {{ [
                                            1 => 'ADSL',
                                            6 => 'VDSL',
                                            7 => 'FIBER',
                                        ][$package['xdsltype']] ?? 'Bilinmeyen' }}
                                • ⬇️ {{ $package['download'] .' Mbps' }}
                                • ⬆️ {{ $package['upload'] .' Mbps' }}
                                • {{ $package['commitment'] ? '🔒 Taahhütlü' : '🔓 Taahhütsüz' }}
                                • {{ $package['quota'] ? '⛔ Kotalı İnternet' : '♾️ Kotasız İnternet' }}

                            </p>

                            <div class="flex justify-between items-center pt-2">
                    <span class="font-bold">
                        {{ number_format($package['price'], 0, ',', '.') }} TL
                    </span>

                                <a href="/paket/{{ $package['id'] }}"
                                   class="text-blue-600 text-sm font-semibold">
                                    İncele →
                                </a>
                            </div>

                        </div>
                    </div>

                @empty

                    <!-- BOŞ DURUM -->
                    <div class="col-span-full text-center text-gray-500 py-20">
                        Uygun paket bulunamadı.
                    </div>

                @endforelse

            </div>
            @if ($packages->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $packages->links('pagination::tailwind') }}
                </div>
            @endif

        </section>

    </div>
</main>
@endsection

@push('styles')
<style>
    body{font-size:14px;}
    span{font-size:14px;}
    .overlay {
        background: rgb(0 0 0 / 55%);
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 1030;
    }
    .search-section {
        padding: 50px 0;
    }
    .filter-header {
        font-weight: bold;
        font-size: 30px;
    }
    .filter-title {
        font-weight: bold;
        font-size: 20px;
        padding-bottom: 14px;
        margin-bottom: 15px;
    }
    .title {
        font-weight: bold;
        font-size: 20px;
        padding-bottom: 0;
        margin-bottom: 15px;
    }
    .mb-30 {
        margin-bottom: 30px;
    }
    .row-grid img{margin-bottom:30px;max-width:100%}
    @media (max-width: 767.98px) {
        .filters-actions {
            position: fixed;
            background: #fff;
            display: flex;
            justify-content: center;
            border:0;
            bottom: 0;
            z-index: 1031;
            left: 0;
            right: 0;
            bottom: 0;
            box-shadow: 0px -2px 3px rgb(0 0 0 / 21%);
            -webkit-box-shadow: 0px -2px 3px rgb(0 0 0 / 21%);
            -moz-box-shadow: 0px -2px 3px rgb(0 0 0 / 21%);
            height: 50px;
        }
        .filters-actions>div {
            flex: 1;
            text-align: center;

        }
        .filters-actions>div:first-of-type{
            border-right: 1px solid #d6d1ce;
        }
        .filters-actions>div>* {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        /*.no-border-select.sort-select + .select2-container--default .select2-selection--single{
          background-image: none;
          padding:10px;
        }*/
        .filter-btn, .filter-btn:hover, .filter-btn:focus, .filter-btn:active {
            padding: 14px 20px;
            height: 50px;
            border: 0;
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 0;
        }
        .sort-drop .dropdown-menu{
            width: 100%;
            left: 0;
            position: fixed !important;
            transform: translateY(100%) !important;
            bottom: 50px !important;
            top: auto !important;
            text-align: center;
            border-radius: 6px 6px 0 0 !important;
            box-shadow: none !important;
            transition: .3s;
            display: block;
            /* border: 0;*/
            z-index: -11;
        }
        .sort-drop .dropdown-menu .dropdown-item{padding:15px 20px !important;}
        .sort-drop .dropdown-menu .dropdown-item:first-child{
            border-radius: 6px 6px 0 0 !important;
        }
        .sort-drop.show .dropdown-menu{
            transform: translateY(0) !important;
        }
        .btn.sort-toggle{
            background-image: none;
            padding:10px !important;
            width: 100%;
            border: 0;
            height: 50px;
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 0;
            font-size: 16px;
            line-height: 22px;
        }
        .sidebar {
            position: fixed;
            transform: translateY(100%);
            -webkit-transform: translateY(100%);
            -moz-transform: translateY(100%);
            -o-transform: translateY(100%);
            transition: .3s;
            -webkit-transition: .3s;
            -moz-transition: .3s;
            -o-transition: .3s;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;

            background: #fff;

        }
        .sidebar.open{
            z-index: 1032;
            transform: translateY(0);
            -webkit-transform: translateY(0);
            -moz-transform: translateY(0);
            -o-transform: translateY(0);
        }
        .sidebar__inner {
            padding: 15px;
            height: calc(100% - 58px);
            overflow-y: auto;
        }
        .filter-header{height: 58px;}
        .filter-body{padding-right: 0;}
    }
    /* RANGE INPUT RESET */
    .range-input {
        -webkit-appearance: none;
        appearance: none;
        pointer-events: none;
        height: 100%;
    }

    /* THUMB */
    .range-input::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        pointer-events: auto;
        height: 16px;
        width: 16px;
        border-radius: 9999px;
        background: #fff;
        border: 2px solid #9333ea;
        cursor: pointer;
    }

    .range-input::-moz-range-thumb {
        pointer-events: auto;
        height: 16px;
        width: 16px;
        border-radius: 9999px;
        background: #fff;
        border: 2px solid #9333ea;
        cursor: pointer;
    }

</style>
@endpush

@push('scripts')
<script>
    function getQueryParam(name, fallback) {
        const params = new URLSearchParams(window.location.search);
        return params.has(name) ? params.get(name) : fallback;
    }


    document.addEventListener("DOMContentLoaded", function () {

        const sidebar = document.querySelector(".sidebar");
        const overlay = document.querySelector(".overlay");
        const body = document.body;

        const openFilterBtn = document.querySelector(".filter-btn");
        const closeFilterBtn = document.querySelector(".filter-close-btn");

        /* =============================
           SIDEBAR OPEN / CLOSE
        ============================== */

        function openSidebar() {
            if (!sidebar) return;
            sidebar.classList.add("open");
            overlay.style.display = "block";
            body.classList.add("overflow-hidden");
        }

        function closeSidebar() {
            if (!sidebar) return;
            sidebar.classList.remove("open");
            overlay.style.display = "none";
            body.classList.remove("overflow-hidden");
        }

        if (openFilterBtn) {
            openFilterBtn.addEventListener("click", openSidebar);
        }

        if (closeFilterBtn) {
            closeFilterBtn.addEventListener("click", closeSidebar);
        }

        if (overlay) {
            overlay.addEventListener("click", closeSidebar);
        }

        /* =============================
           RESPONSIVE RESET
        ============================== */

        window.addEventListener("resize", function () {
            if (window.innerWidth >= 768) {
                overlay.style.display = "none";
                body.classList.remove("overflow-hidden");
                sidebar.classList.remove("open");
            }
        });

    });
    document.addEventListener("DOMContentLoaded", function () {

        const minRange = document.getElementById("minRange");
        const maxRange = document.getElementById("maxRange");

        const minBubble = document.getElementById("minBubble");
        const maxBubble = document.getElementById("maxBubble");

        const rangeFill = document.getElementById("rangeFill");

        const minInput = document.getElementById("minPriceInput");
        const maxInput = document.getElementById("maxPriceInput");

        const MIN_GAP = 100;
        const MAX_VALUE = 10000;

        function updateUI() {
            let minVal = parseInt(minRange.value);
            let maxVal = parseInt(maxRange.value);

            if (maxVal - minVal < MIN_GAP) {
                if (this === minRange) {
                    minRange.value = maxVal - MIN_GAP;
                    minVal = minRange.value;
                } else {
                    maxRange.value = minVal + MIN_GAP;
                    maxVal = maxRange.value;
                }
            }

            minBubble.textContent = minVal.toLocaleString("tr-TR") + " TL";
            maxBubble.textContent = maxVal.toLocaleString("tr-TR") + " TL";

            minInput.value = minVal;
            maxInput.value = maxVal;

            const left = (minVal / MAX_VALUE) * 100;
            const width = ((maxVal - minVal) / MAX_VALUE) * 100;

            rangeFill.style.left = left + "%";
            rangeFill.style.width = width + "%";
        }

        minRange.addEventListener("input", updateUI);
        maxRange.addEventListener("input", updateUI);
// URL'den değer al
        minRange.value = getQueryParam("min_price", minRange.value);
        maxRange.value = getQueryParam("max_price", maxRange.value);

        minInput.value = minRange.value;
        maxInput.value = maxRange.value;

        updateUI();
    });

    document.addEventListener("DOMContentLoaded", function () {

        const minR = document.getElementById("minDownloadRange");
        const maxR = document.getElementById("maxDownloadRange");

        const minB = document.getElementById("minDownloadBubble");
        const maxB = document.getElementById("maxDownloadBubble");

        const fill = document.getElementById("downloadRangeFill");

        const minInput = document.getElementById("downloadMinInput");
        const maxInput = document.getElementById("downloadMaxInput");

        const MIN_GAP = 0;
        const MAX_VALUE = 1000;

        function updateDownloadUI() {
            let minVal = parseInt(minR.value);
            let maxVal = parseInt(maxR.value);

            if (maxVal - minVal < MIN_GAP) {
                if (this === minR) {
                    minR.value = maxVal - MIN_GAP;
                    minVal = minR.value;
                } else {
                    maxR.value = minVal + MIN_GAP;
                    maxVal = maxR.value;
                }
            }

            minB.textContent = minVal + " Mbps";
            maxB.textContent = maxVal + " Mbps";

            minInput.value = minVal;
            maxInput.value = maxVal;

            const left = (minVal / MAX_VALUE) * 100;
            const width = ((maxVal - minVal) / MAX_VALUE) * 100;

            fill.style.left = left + "%";
            fill.style.width = width + "%";
        }

        minR.addEventListener("input", updateDownloadUI);
        maxR.addEventListener("input", updateDownloadUI);

        minR.value = getQueryParam("download_min", minR.value);
        maxR.value = getQueryParam("download_max", maxR.value);

        minInput.value = minR.value;
        maxInput.value = maxR.value;


        updateDownloadUI();
    });

    document.addEventListener("DOMContentLoaded", function () {

        const minR = document.getElementById("minUploadRange");
        const maxR = document.getElementById("maxUploadRange");

        const minB = document.getElementById("minUploadBubble");
        const maxB = document.getElementById("maxUploadBubble");

        const fill = document.getElementById("uploadRangeFill");

        const minInput = document.getElementById("uploadMinInput");
        const maxInput = document.getElementById("uploadMaxInput");

        const MIN_GAP = 0;
        const MAX_VALUE = 1000;

        function updateUploadUI() {
            let minVal = parseInt(minR.value);
            let maxVal = parseInt(maxR.value);

            if (maxVal - minVal < MIN_GAP) {
                if (this === minR) {
                    minR.value = maxVal - MIN_GAP;
                    minVal = minR.value;
                } else {
                    maxR.value = minVal + MIN_GAP;
                    maxVal = maxR.value;
                }
            }

            minB.textContent = minVal + " Mbps";
            maxB.textContent = maxVal + " Mbps";


            minInput.value = minVal;
            maxInput.value = maxVal;

            const left = (minVal / MAX_VALUE) * 100;
            const width = ((maxVal - minVal) / MAX_VALUE) * 100;

            fill.style.left = left + "%";
            fill.style.width = width + "%";
        }

        minR.addEventListener("input", updateUploadUI);
        maxR.addEventListener("input", updateUploadUI);

        minR.value = getQueryParam("upload_min", minR.value);
        maxR.value = getQueryParam("upload_max", maxR.value);

        minInput.value = minR.value;
        maxInput.value = maxR.value;


        updateUploadUI();
    });

    document.addEventListener("DOMContentLoaded", function () {

        const searchBtn = document.getElementById("searchBtn");

        searchBtn.addEventListener("click", function () {

            /* =============================
               ALTYAPI (checkbox)
            ============================== */
            const altyapilar = Array.from(
                document.querySelectorAll('input[name="altyapi[]"]:checked')
            ).map(cb => cb.value);


            /* =============================
               ISS (checkbox)
            ============================== */
            const issler = Array.from(
                document.querySelectorAll('input[name="iss[]"]:checked')
            ).map(cb => cb.value);

            /* =============================
               FİYAT ARALIĞI
            ============================== */
            const minPrice = document.getElementById("minPriceInput")?.value ?? null;
            const maxPrice = document.getElementById("maxPriceInput")?.value ?? null;

            /* =============================
               İNDİRME HIZI
            ============================== */
            const downloadMin = document.getElementById("downloadMinInput")?.value ?? null;
            const downloadMax = document.getElementById("downloadMaxInput")?.value ?? null;

            /* =============================
               YÜKLEME HIZI
            ============================== */
            const uploadMin = document.getElementById("uploadMinInput")?.value ?? null;
            const uploadMax = document.getElementById("uploadMaxInput")?.value ?? null;

            /* =============================
               TAAHHÜT & KOTA
            ============================== */
            const commitment = document.getElementById("commitmentSelect")?.value ?? "";
            const quota = document.getElementById("quotaSelect")?.value ?? "";

            /* =============================
               TÜM FİLTRELER
            ============================== */
            const filters = {
                altyapi: altyapilar,
                iss: issler,
                price: { min: minPrice, max: maxPrice },
                download: { min: downloadMin, max: downloadMax },
                upload: { min: uploadMin, max: uploadMax },
                commitment: commitment,
                quota: quota
            };

            console.log("Seçilen Filtreler:", filters);

            /* =============================
               BACKEND'E GÖNDER (GET)
            ============================== */
            const params = new URLSearchParams();

            altyapilar.forEach(a => params.append("altyapi[]", a));
            issler.forEach(i => params.append("iss[]", i));

            if (minPrice) params.append("min_price", minPrice);
            if (maxPrice) params.append("max_price", maxPrice);

            if (downloadMin) params.append("download_min", downloadMin);
            if (downloadMax) params.append("download_max", downloadMax);

            if (uploadMin) params.append("upload_min", uploadMin);
            if (uploadMax) params.append("upload_max", uploadMax);

            if (commitment !== "") params.append("commitment", commitment);
            if (quota !== "") params.append("quota", quota);

            // yönlendir
            window.location.href = "/paketler?" + params.toString();
        });

    });
    document.addEventListener("DOMContentLoaded", function () {

        const params = new URLSearchParams(window.location.search);

        const commitmentSelect = document.getElementById("commitmentSelect");
        const quotaSelect = document.getElementById("quotaSelect");

        // Taahhüt
        if (commitmentSelect) {
            const commitment = params.get("commitment");
            if (commitment !== null) {
                commitmentSelect.value = commitment;
            } else {
                commitmentSelect.value = "2"; // Tümü
            }
        }

        // Kota
        if (quotaSelect) {
            const quota = params.get("quota");
            if (quota !== null) {
                quotaSelect.value = quota;
            } else {
                quotaSelect.value = "2"; // Tümü
            }
        }

    });


</script>
@endpush

