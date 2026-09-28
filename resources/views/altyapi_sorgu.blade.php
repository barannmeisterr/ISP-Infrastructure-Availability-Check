@extends('layouts.app')

@push('styles')
<!-- Choices.js CSS -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
/>
@endpush

@section('content')
<!-- HERO -->
<section class="py-28">
    <div class="max-w-6xl mx-auto text-center px-6">


        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            Adresinize uygun internet altyapısını hemen öğrenin! Altyapınızı kontrol ederek, ideal paketinize başvuru yapın ve alabileceğiniz maksimum hızı öğrenin.
        </h1>



        <p class="text-gray-600 text-lg max-w-3xl mx-auto">
            IssAltyapı ile altyapı kontrollerinizi detaylı olarak gerçekleştirin.
            Çıkan sonuçlar ile altyapınızı kontrol ederek, başvurunuzu
            gerçekleştirebilirsiniz. En doğru sonuçları elde etmek için
            elimizden geleni yapıyoruz.
        </p>

    </div>
</section>

<!-- ALTYAPI SORGULAMA FORM -->
<section class="pb-32">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- SOLDA FORM -->
            <div class="max-w-2xl">

                <form class="space-y-6">

                    <div>
                        <label class="block font-semibold mb-2">İl</label>

                        <select
                            id="il"
                            name="il"
                            required
                            class="w-full border-2 border-gray-900 rounded-xl px-4 py-4 focus:outline-none"
                        >

                            <option value="" selected>Seçiniz...</option>

                        </select>
                    </div>

                    <div id="ilce-wrapper" class="hidden">
                        <label class="block font-semibold mb-2">İlçe</label>
                        <select
                            id="ilce"
                            name="ilce"
                            class="w-full border-2 border-gray-900 rounded-xl px-4 py-4 focus:outline-none"
                        >
                            <option value="" selected>Seçiniz...</option>

                        </select>
                    </div>
                    <div id="bucak-wrapper" class="hidden">
                        <label class="block font-semibold mb-2">Bucak</label>
                        <select
                            id="bucak"
                            name="bucak"
                            class="w-full border-2 border-gray-900 rounded-xl px-4 py-4 focus:outline-none"
                        >
                            <option value="" selected>Seçiniz...</option>

                        </select>
                    </div>

                    <div id="mahalle-wrapper" class="hidden">
                        <label class="block font-semibold mb-2">Mahalle</label>
                        <select id="mahalle" name="mahalle"
                                class="w-full border-2 border-gray-900 rounded-xl px-4 py-4 focus:outline-none">
                            <option value="" selected>Seçiniz...</option>

                        </select>
                    </div>


                    <div id="csbm-wrapper" class="hidden">
                        <label class="block font-semibold mb-2">
                            CSBM (Cadde, Sokak, Bulvar, Meydan)
                        </label>
                        <select
                            id="csbm"
                            name="csbm"
                            class="w-full border-2 border-gray-900 rounded-xl px-4 py-4 focus:outline-none"
                        >
                            <option value="" selected>Seçiniz...</option>

                        </select>
                    </div>


                    <div id="bina-wrapper" class="hidden">
                        <label class="block font-semibold mb-2">Bina Numarası</label>
                        <select
                            id="bina"
                            name="binaNo"
                            class="w-full border-2 border-gray-900 rounded-xl px-4 py-4 focus:outline-none"
                        >
                            <option value="" selected>Seçiniz...</option>

                        </select>
                    </div>


                    <div id="ickapi-wrapper" class="hidden">
                        <label class="block font-semibold mb-2">İç Kapı Numarası</label>
                        <select
                            id="ickapi"
                            name="icKapiNo"
                            class="w-full border-2 border-gray-900 rounded-xl px-4 py-4 focus:outline-none"
                        >
                            <option value="" selected>Seçiniz...</option>

                        </select>
                    </div>


                    <div class="pt-4">
                        <button
                            id="submitBtn"
                            type="button"
                            class="w-full bg-gray-900 text-white font-semibold py-4 rounded-xl hover:bg-gray-800 transition hidden">
                            Altyapıyı Sorgula
                        </button>
                    </div>

                </form>

            </div>




            <!-- SAĞ KOLON -->
            <div class="flex flex-col items-center gap-4">

                <!-- TOGGLE SWITCH -->
                <label for="filter" class="switch hidden" aria-label="Toggle Filter">
                    <input type="checkbox" id="filter" />
                    <span>ISS Altyapıları</span>
                    <span>Türk Telekom Altyapısı</span>
                </label>



                <!-- RESULT CARD -->
                <div id="resultCard" class="flex justify-center hidden">

                    <div class="w-full max-w-sm border-2 border-gray-900 rounded-2xl overflow-hidden bg-white">

                        <!-- SPEEDOMETER -->
                        <div class="p-6 text-center border-b">
                            <canvas id="speedGauge" width="300" height="190" class="mx-auto"></canvas>

                            <div id="speedValue" class="mt-4 text-3xl font-extrabold">
                                -
                            </div>
                            <div id="speedType" class="text-sm text-gray-600">
                                -
                            </div>
                        </div>

                        <!-- ================= FIBER ================= -->
                        <div id="fiberLabel" class="bg-green-400 text-center font-bold py-2 text-white">
                            FİBER
                        </div>

                        <div class="grid grid-cols-3 gap-6 p-4 text-center text-xs">
                            <div>
                                <div class="text-2xl">🖧</div>
                                <span id="fiber_santral_hizmet" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Santral Hizmeti</div>
                            </div>

                            <div>
                                <div class="text-2xl">🔌</div>
                                <span id="fiber_bos_port" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Boş Port</div>
                            </div>

                            <div>
                                <div class="text-2xl">⚡</div>
                                <span id="fiber_hiz" class="bg-green-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Hız</div>
                            </div>

                            <div>
                                <div class="text-2xl">🗄️</div>
                                <span id="fiber_santral_adi" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Santral Adı</div>
                            </div>

                            <div>
                                <div class="text-2xl">🏢</div>
                                <span id="fiber_santral_mudurluk_adi" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Müdürlük</div>
                            </div>

                            <div>
                                <div class="text-2xl">📍</div>
                                <span id="fiber_santral_mesafe" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Mesafe</div>
                            </div>
                        </div>

                        <!-- ================= VDSL ================= -->
                        <div id="vdslLabel" class="bg-green-400 text-center font-bold py-2 text-white">
                            VDSL
                        </div>

                        <div class="grid grid-cols-3 gap-6 p-4 text-center text-xs">
                            <div>
                                <div class="text-2xl">🖧</div>
                                <span id="vdsl_santral_hizmet" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Santral Hizmeti</div>
                            </div>

                            <div>
                                <div class="text-2xl">🔌</div>
                                <span id="vdsl_bos_port" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Boş Port</div>
                            </div>

                            <div>
                                <div class="text-2xl">⚡</div>
                                <span id="vdsl_hiz" class="bg-green-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Hız</div>
                            </div>

                            <div>
                                <div class="text-2xl">🗄️</div>
                                <span id="vdsl_santral_adi" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Santral Adı</div>
                            </div>

                            <div>
                                <div class="text-2xl">🏢</div>
                                <span id="vdsl_santral_mudurluk_adi" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Müdürlük</div>
                            </div>

                            <div>
                                <div class="text-2xl">📍</div>
                                <span id="vdsl_santral_mesafe" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Mesafe</div>
                            </div>
                        </div>

                        <!-- ================= ADSL ================= -->
                        <div id="adslLabel" class="bg-green-400 text-center font-bold py-2 text-white">
                            ADSL
                        </div>

                        <div class="grid grid-cols-3 gap-6 p-4 text-center text-xs">
                            <div>
                                <div class="text-2xl">🖧</div>
                                <span id="adsl_santral_hizmet" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Santral Hizmeti</div>
                            </div>

                            <div>
                                <div class="text-2xl">🔌</div>
                                <span id="adsl_bos_port" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Boş Port</div>
                            </div>

                            <div>
                                <div class="text-2xl">⚡</div>
                                <span id="adsl_hiz" class="bg-green-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Hız</div>
                            </div>

                            <div>
                                <div class="text-2xl">🗄️</div>
                                <span id="adsl_santral_adi" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Santral Adı</div>
                            </div>

                            <div>
                                <div class="text-2xl">🏢</div>
                                <span id="adsl_santral_mudurluk_adi" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Müdürlük</div>
                            </div>

                            <div>
                                <div class="text-2xl">📍</div>
                                <span id="adsl_santral_mesafe" class="bg-green-500 text-white px-2 py-1 rounded block">-</span>
                                <div class="mt-1 font-semibold">Mesafe</div>
                            </div>
                        </div>

                        <button
                            type="button"
                            id="altyapiSorguFoundPaketlerButton"
                            class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-4 transition">
                            Paketleri Görüntüle →
                        </button>

                    </div>
                </div>
                <div id="issAltyapiResultCard" class="flex justify-center hidden">

                    <div class="w-full max-w-sm border-2 border-gray-900 rounded-2xl overflow-hidden bg-white">

                        <!-- SPEEDOMETER -->
                        <div class="p-6 text-center border-b">


                            <div id="speedValueForIss" class="mt-4 text-3xl font-extrabold">
                                -
                            </div>
                            <div id="speedTypeForIss" class="text-sm text-gray-600">
                                -
                            </div>
                        </div>

                        <!-- ================= FIBER ================= -->
                        <div id="issFiberLabel" class="bg-green-400 text-center font-bold py-2 text-white">
                            FİBER
                        </div>

                        <div class="grid grid-cols-3 gap-6 p-4 text-center text-xs">
                            <div>
                                <div class="text-2xl">🖧</div>
                                <span id="iss_fiber_santral_hizmet" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">ISS Altyapı Hizmeti</div>
                            </div>



                            <div>
                                <div class="text-2xl">⚡</div>
                                <span id="iss_fiber_hiz" class="bg-green-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Hız</div>
                            </div>


                        </div>

                        <!-- ================= VDSL ================= -->
                        <div id="issVdslLabel" class="bg-green-400 text-center font-bold py-2 text-white">
                            VDSL
                        </div>

                        <div class="grid grid-cols-3 gap-6 p-4 text-center text-xs">
                            <div>
                                <div class="text-2xl">🖧</div>
                                <span id="iss_vdsl_santral_hizmet" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">ISS Altyapı Hizmeti</div>
                            </div>



                            <div>
                                <div class="text-2xl">⚡</div>
                                <span id="iss_vdsl_hiz" class="bg-green-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Hız</div>
                            </div>


                        </div>

                        <!-- ================= ADSL ================= -->
                        <div id="issAdslLabel" class="bg-green-400 text-center font-bold py-2 text-white">
                            ADSL
                        </div>

                        <div class="grid grid-cols-3 gap-6 p-4 text-center text-xs">
                            <div>
                                <div class="text-2xl">🖧</div>
                                <span id="iss_adsl_santral_hizmet" class="bg-red-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">ISS Altyapı Hizmeti</div>
                            </div>

                            <div>
                                <div class="text-2xl">⚡</div>
                                <span id="iss_adsl_hiz" class="bg-green-500 text-white px-2 py-1 rounded">-</span>
                                <div class="mt-1 font-semibold">Hız</div>
                            </div>


                        </div>

                        <button
                            type="button"
                            id="IssAltyapiSorguFoundPaketlerButton"
                            class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-4 transition">
                            Paketleri Görüntüle →
                        </button>

                    </div>
                </div>
            </div>

        </div>

    </div>

    </div>
</section>
@endsection

@push('styles')
<style>
    /* From Uiverse.io by cbolson */
    .switch {
        --_switch-bg-clr: #70a9c5;
        --_switch-padding: 4px; /* padding around button*/
        --_slider-bg-clr: rgba(12, 74, 110, 0.65); /* slider color unchecked */
        --_slider-bg-clr-on: rgba(12, 74, 110, 1); /* slider color checked */
        --_slider-txt-clr: #ffffff;
        --_label-padding: 1rem 2rem; /* padding around the labels -  this gives the switch it's global width and height */
        --_switch-easing: cubic-bezier(
            0.47,
            1.64,
            0.41,
            0.8
        ); /* easing on toggle switch */
        color: white;
        width: fit-content;
        display: flex;
        justify-content: center;
        position: relative;
        border-radius: 9999px;
        cursor: pointer;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        position: relative;
        isolation: isolate;
    }

    .switch input[type="checkbox"] {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }
    .switch > span {
        display: grid;
        place-content: center;
        transition: opacity 300ms ease-in-out 150ms;
        padding: var(--_label-padding);
    }
    .switch::before,
    .switch::after {
        content: "";
        position: absolute;
        border-radius: inherit;
        transition: inset 150ms ease-in-out;
    }
    /* switch slider */
    .switch::before {
        background-color: var(--_slider-bg-clr);
        inset: var(--_switch-padding) 50% var(--_switch-padding)
        var(--_switch-padding);
        transition:
            inset 500ms var(--_switch-easing),
            background-color 500ms ease-in-out;
        z-index: -1;
        box-shadow:
            inset 0 1px 1px rgba(0, 0, 0, 0.3),
            0 1px rgba(255, 255, 255, 0.3);
    }
    /* switch bg color */
    .switch::after {
        background-color: var(--_switch-bg-clr);
        inset: 0;
        z-index: -2;
    }
    /* switch hover & focus */
    .switch:focus-within::after {
        inset: -0.25rem;
    }
    .switch:has(input:checked):hover > span:first-of-type,
    .switch:has(input:not(:checked)):hover > span:last-of-type {
        opacity: 1;
        transition-delay: 0ms;
        transition-duration: 100ms;
    }
    /* switch hover */
    .switch:has(input:checked):hover::before {
        inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
        45%;
    }
    .switch:has(input:not(:checked)):hover::before {
        inset: var(--_switch-padding) 45% var(--_switch-padding)
        var(--_switch-padding);
    }
    /* checked - move slider to right */
    .switch:has(input:checked)::before {
        background-color: var(--_slider-bg-clr-on);
        inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
        50%;
    }
    /* checked - set opacity */
    .switch > span:last-of-type,
    .switch > input:checked + span:first-of-type {
        opacity: 0.75;
    }
    .switch > input:checked ~ span:last-of-type {
        opacity: 1;
    }

    .switch.hidden {
        display: none !important;
    }

    /* === ANA CONTAINER === */
    .choices {
        margin-bottom: 0;
        font-size: 16px;
    }

    /* === SELECT KUTUSU === */
    .choices__inner {
        min-height: 56px;
        padding: 14px 16px;
        border: 2px solid #111827; /* gray-900 */
        border-radius: 12px;
        background-color: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    /* === HOVER === */
    .choices__inner:hover {
        border-color: #2563eb; /* blue-600 */
    }

    /* === FOCUS === */
    .is-focused .choices__inner,
    .is-open .choices__inner {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    /* === SEÇİLİ METİN === */
    .choices__item--selectable {
        color: #111827;
        font-weight: 500;
    }

    /* === PLACEHOLDER === */
    .choices__placeholder {
        color: #9ca3af; /* gray-400 */
        opacity: 1;
    }

    /* === OK (dropdown arrow) === */
    .choices[data-type*="select-one"]::after {
        border-color: #111827 transparent transparent transparent;
        margin-top: -2.5px;
    }

    /* === DROPDOWN === */
    .choices__list--dropdown {
        border: 2px solid #111827;
        border-radius: 12px;
        margin-top: 6px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        z-index: 50;
    }

    /* === DROPDOWN ITEM === */
    .choices__list--dropdown .choices__item {
        padding: 12px 16px;
        font-size: 15px;
    }

    /* === HOVER ITEM === */
    .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: #eff6ff; /* blue-50 */
        color: #1d4ed8; /* blue-700 */
    }

    /* === SEARCH INPUT === */
    .choices__input {
        padding: 10px 0;
        font-size: 15px;
        color: #111827;
    }

    /* === SEARCH PLACEHOLDER === */
    .choices__input::placeholder {
        color: #9ca3af;
    }

    /* === DISABLED === */
    .choices.is-disabled .choices__inner {
        background-color: #f3f4f6;
        cursor: not-allowed;
        opacity: 0.7;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/gaugeJS/dist/gauge.min.js"></script>
<!-- Choices.js -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    // ELEMENTLER
    const il = document.getElementById('il');
    const ilce = document.getElementById('ilce');
    const bucak = document.getElementById('bucak');
    const mahalle = document.getElementById('mahalle');
    const csbm = document.getElementById('csbm');
    const bina = document.getElementById('bina');
    const ickapi = document.getElementById('ickapi');
    const submitBtn = document.getElementById('submitBtn');
    const paketlerBtn = document.getElementById('altyapiSorguFoundPaketlerButton');
    const issAltyapiPaketlerBtn = document.getElementById('IssAltyapiSorguFoundPaketlerButton');
    const ilceW = document.getElementById('ilce-wrapper');
    const bucakW = document.getElementById('bucak-wrapper');
    const mahalleW = document.getElementById('mahalle-wrapper');
    const csbmW = document.getElementById('csbm-wrapper');
    const binaW = document.getElementById('bina-wrapper');
    const ickapiW = document.getElementById('ickapi-wrapper');
    const altyapiToggleLabel = document.querySelector('label.switch');
    const altyapiToggle = document.getElementById('filter');
    const issAltyapiResultCard =document.getElementById('issAltyapiResultCard');
    const resultCard = document.getElementById('resultCard');


    let fiberVarMiValue = 0;
    let vdslVarMiValue  = 0;
    let adslVarMiValue  = 0;
    let telekomFiberMaxSupportedSpeed = 0;
    let telekomVdslMaxSupportedSpeed = 0;
    let telekomAdslMaxSupportedSpeed = 0;
    let lastGaugeSpeed = null;
    let lastGaugeSpeedForIssAltyapi= null;
    let altyapiSorguYapildi = false;


    function isVisibleAndSelected(wrapper, select) {
        return !wrapper.classList.contains('hidden') && select.value;
    }

    function checkFormCompletion() {
        const completed =
            il.value &&
            isVisibleAndSelected(ilceW, ilce) &&
            isVisibleAndSelected(bucakW, bucak) &&
            isVisibleAndSelected(mahalleW, mahalle) &&
            isVisibleAndSelected(csbmW, csbm) &&
            isVisibleAndSelected(binaW, bina) &&
            isVisibleAndSelected(ickapiW, ickapi);

        submitBtn.classList.toggle('hidden', !completed);
    }

    function resetAndHide(fromWrappers) {
        fromWrappers.forEach(({ wrapper, select }) => {
            wrapper.classList.add('hidden');
            select.value = '';
            select.required = false;
        });
    }
    function applyToggleState() {

        if (!altyapiSorguYapildi) {
            resultCard.classList.add('hidden');
            issAltyapiResultCard.classList.add('hidden');
            return;
        }

        if (!altyapiToggle) return;

        const isTurkTelekom = altyapiToggle.checked;

        if (isTurkTelekom) {
            // ✅ Türk Telekom
            resultCard.classList.remove('hidden');
            issAltyapiResultCard.classList.add('hidden');

            // 🔥 Gauge SADECE görünürken çizilir
            setTimeout(() => {
                if (lastGaugeSpeed !== null) {
                    if (!gaugeInstance) {
                        initGauge(lastGaugeSpeed);
                    } else {
                        gaugeInstance.set(lastGaugeSpeed);
                    }

                    document.getElementById("speedValue").innerText =
                        lastGaugeSpeed > 0
                            ? `${lastGaugeSpeed} Mbps`
                            : 'Hizmet Verilememektedir';
                }
            }, 80);

        } else {
            // ✅ ISS

            resultCard.classList.add('hidden');
            issAltyapiResultCard.classList.remove('hidden');
        }
    }




    altyapiToggle.addEventListener('change', applyToggleState);

    /* ================= EVENTS ================= */

    // İL
    il.addEventListener('change', () => {
        resetAndHide([
            { wrapper: ilceW, select: ilce },
            { wrapper: bucakW, select: bucak },
            { wrapper: mahalleW, select: mahalle },
            { wrapper: csbmW, select: csbm },
            { wrapper: binaW, select: bina },
            { wrapper: ickapiW, select: ickapi },
        ]);

        if (!il.value) return;

        ilceW.classList.remove('hidden');
        ilce.required = true;

        checkFormCompletion();
    });

    // İLÇE
    ilce.addEventListener('change', () => {
        resetAndHide([
            { wrapper: bucakW, select: bucak },
            { wrapper: mahalleW, select: mahalle },
            { wrapper: csbmW, select: csbm },
            { wrapper: binaW, select: bina },
            { wrapper: ickapiW, select: ickapi },
        ]);

        if (!ilce.value) return;

        bucakW.classList.remove('hidden');
        bucak.required = true;

        checkFormCompletion();
    });

    // BUCAK
    bucak.addEventListener('change', () => {
        resetAndHide([
            { wrapper: mahalleW, select: mahalle },
            { wrapper: csbmW, select: csbm },
            { wrapper: binaW, select: bina },
            { wrapper: ickapiW, select: ickapi },
        ]);

        if (!bucak.value) return;

        mahalleW.classList.remove('hidden');
        mahalle.required = true;

        checkFormCompletion();
    });

    // MAHALLE
    mahalle.addEventListener('change', () => {
        resetAndHide([
            { wrapper: csbmW, select: csbm },
            { wrapper: binaW, select: bina },
            { wrapper: ickapiW, select: ickapi },
        ]);

        if (!mahalle.value) return;

        csbmW.classList.remove('hidden');
        csbm.required = true;

        checkFormCompletion();
    });

    // CSBM
    csbm.addEventListener('change', () => {
        resetAndHide([
            { wrapper: binaW, select: bina },
            { wrapper: ickapiW, select: ickapi },
        ]);

        if (!csbm.value) return;

        binaW.classList.remove('hidden');
        bina.required = true;

        checkFormCompletion();
    });

    // BİNA
    bina.addEventListener('change', () => {
        resetAndHide([
            { wrapper: ickapiW, select: ickapi },
        ]);

        if (!bina.value) return;

        ickapiW.classList.remove('hidden');
        ickapi.required = true;

        checkFormCompletion();
    });

    // İÇ KAPI
    ickapi.addEventListener('change', checkFormCompletion);


    async function fetchUavt(url) {
        const res = await fetch(url);
        if (!res.ok) return [];
        const json = await res.json();
        return json.data ?? [];
    }
    async function fetchAltyapiSorgu(url) {
        const res = await fetch(url);
        if (!res.ok) return [];
        const json = await res.json();
        return json.data ?? [];
    }



    function fillSelect(select, items) {
        select.innerHTML = '<option value="">Seçiniz...</option>';
        items.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.kod;
            opt.textContent = item.ad;
            select.appendChild(opt);
        });
        initChoice(select.id);
    }

    /* ===================== LOADERS ===================== */

    // SAYFA AÇILINCA → İLLER
    document.addEventListener('DOMContentLoaded', async () => {
        const iller = await fetchUavt('/uavt/iller');
        fillSelect(il, iller);
    });

    // İL → İLÇE
    il.addEventListener('change', async () => {
        if (!il.value) return;

        const ilceler = await fetchUavt(`/uavt/ilceler/${il.value}`);
        fillSelect(ilce, ilceler);
    });

    // İLÇE → BUCAK
    ilce.addEventListener('change', async () => {
        if (!ilce.value) return;

        const bucaklar = await fetchUavt(`/uavt/bucaklar/${ilce.value}`);
        fillSelect(bucak, bucaklar);
    });

    // BUCAK → MAHALLE
    bucak.addEventListener('change', async () => {
        if (!bucak.value) return;

        const mahalleler = await fetchUavt(`/uavt/mahalleler/${bucak.value}`);
        fillSelect(mahalle, mahalleler);
    });

    // MAHALLE → CSBM (sokak)
    mahalle.addEventListener('change', async () => {
        if (!mahalle.value) return;

        const sokaklar = await fetchUavt(`/uavt/sokaklar/${mahalle.value}`);
        fillSelect(csbm, sokaklar);
    });

    // CSBM → BİNA
    csbm.addEventListener('change', async () => {
        if (!csbm.value) return;

        const binalar = await fetchUavt(`/uavt/binalar/${csbm.value}`);
        fillSelect(bina, binalar);
    });

    // BİNA → DAİRE
    bina.addEventListener('change', async () => {
        if (!bina.value) return;

        const daireler = await fetchUavt(`/uavt/daireler/${bina.value}`);
        fillSelect(ickapi, daireler);
    });

    submitBtn.addEventListener('click', async () => {

        const bbk = Number(ickapi.value);
        if (!bbk) {
            alert('BBK bulunamadı');
            return;
        }

        // 🔥 web.php route kullanılıyor
        const data = await fetchAltyapiSorgu(
            `/altyapi/altyapiHizmetSorgu/${bbk}`
        );


        if (!data) {
            alert('Altyapı bilgisi alınamadı');
            return;
        }

        // ===============================
        // ISS ALTYAPILARI (AYNI YAPI)
        // ===============================
        const issData = await fetchAltyapiSorgu(
            `/altyapi/iss-altyapi-sorgu/` +
            `${Number(il.value)}/` +
            `${Number(ilce.value)}/` +
            `${Number(mahalle.value)}/` +
            `${Number(csbm.value)}/` +
            `${Number(bina.value)}`
        );




        fiberVarMiValue = data.fiber_var_mi === true ? 1 : 0;
        vdslVarMiValue  = data.vdsl_var_mi  === true ? 1 : 0;
        adslVarMiValue  = data.adsl_var_mi  === true ? 1 : 0;
        telekomFiberMaxSupportedSpeed = data.fiber_hiz;
        telekomVdslMaxSupportedSpeed = data.vdsl_hiz;
        telekomAdslMaxSupportedSpeed = data.adsl_hiz;



        setBaglantiTuruLabel('issFiberLabel','FIBER',issData.iss_fiber_var_mi);
        setBadgeForIssAltyapi('iss_fiber_santral_hizmet',issData.iss_fiber_var_mi);
        setSpeed('iss_fiber_hiz', issData.iss_fiber_hiz ?? 0);

        setBaglantiTuruLabel('issVdslLabel','VDSL',issData.iss_vdsl_var_mi);
        setBadgeForIssAltyapi('iss_vdsl_santral_hizmet',issData.iss_vdsl_var_mi);
        setSpeed('iss_vdsl_hiz', issData.iss_vdsl_hiz ?? 0);

        setBaglantiTuruLabel('issAdslLabel','ADSL',issData.iss_adsl_var_mi);
        setBadgeForIssAltyapi('iss_adsl_santral_hizmet',issData.iss_adsl_var_mi);
        setSpeed('iss_adsl_hiz', issData.iss_adsl_hiz ?? 0);
        lastGaugeSpeedForIssAltyapi =issData.gauge_max_hiz;
        setBaglantiTuruText('speedTypeForIss',issData.gauge_altyapi_turu);
        document.getElementById('speedValueForIss').innerText =
            issData.gauge_max_hiz > 0
                ? `${issData.gauge_max_hiz} Mbps`
                : '-';



        // === FIBER ===
        setBaglantiTuruLabel('fiberLabel','FİBER',data.fiber_var_mi);
        setBadge('fiber_santral_hizmet', data.fiber_santral_hizmet);
        setBadge('fiber_bos_port', data.fiber_bos_port);
        setSpeed('fiber_hiz', data.fiber_hiz);
        setText('fiber_santral_adi', data.fiber_santral_adi, data.fiber_var_mi);
        setText('fiber_santral_mudurluk_adi', data.fiber_santral_mudurluk_adi, data.fiber_var_mi);
        setText('fiber_santral_mesafe', data.fiber_santral_mesafe + ' m', data.fiber_var_mi);

        // === VDSL ===
        setBaglantiTuruLabel('vdslLabel','VDSL',data.vdsl_var_mi);
        setBadge('vdsl_santral_hizmet', data.vdsl_santral_hizmet);
        setBadge('vdsl_bos_port', data.vdsl_bos_port);
        setSpeed('vdsl_hiz', data.vdsl_hiz);
        setText('vdsl_santral_adi', data.vdsl_santral_adi, data.vdsl_var_mi);
        setText('vdsl_santral_mudurluk_adi', data.vdsl_santral_mudurluk_adi,data.vdsl_var_mi);
        setText('vdsl_santral_mesafe', data.vdsl_santral_mesafe + ' m',data.vdsl_var_mi);

        // === ADSL ===
        setBaglantiTuruLabel('adslLabel','ADSL',data.adsl_var_mi);
        setBadge('adsl_santral_hizmet', data.adsl_santral_hizmet);
        setBadge('adsl_bos_port', data.adsl_bos_port);
        setSpeed('adsl_hiz', data.adsl_hiz);
        setText('adsl_santral_adi', data.adsl_santral_adi,data.adsl_var_mi);
        setText('adsl_santral_mudurluk_adi', data.adsl_santral_mudurluk_adi,data.adsl_var_mi);
        setText('adsl_santral_mesafe', data.adsl_santral_mesafe + ' m',data.adsl_var_mi);
        //=== Genel Ayarlar ===
        setBaglantiTuruText('speedType',data.gauge_altyapi_turu);
        setFoundPaketlerButtonLabel('altyapiSorguFoundPaketlerButton', data.fiber_var_mi, data.vdsl_var_mi, data.adsl_var_mi);
        lastGaugeSpeed = data.gauge_max_hiz;


        // 🔓 Toggle artık görünsün
        altyapiToggleLabel.classList.remove('hidden');


        altyapiSorguYapildi = true;
// 🔁 Toggle durumuna göre doğru kartı aç
        applyToggleState();

// ⬇️ Scroll
        (altyapiToggle.checked ? resultCard : issAltyapiResultCard)
            .scrollIntoView({ behavior: 'smooth', block: 'center' });

    });

    paketlerBtn.addEventListener('click', () => {

        const ilIdForPaket       = Number(il.value);
        const ilceIdForPaket     = Number(ilce.value);
        const mahalleIdForPaket  = Number(mahalle.value);
        const csbmIdForPaket     = Number(csbm.value);
        const binaIdForPaket     = Number(bina.value);

        // 🔒 Güvenlik kontrolü
        if (
            !ilIdForPaket ||
            !ilceIdForPaket ||
            !mahalleIdForPaket ||
            !csbmIdForPaket ||
            !binaIdForPaket
        ) {
            alert('Adres bilgileri eksik');
            return;
        }

        // 🔥 Route’a uygun URL
        const url =
            `/altyapi-sorgu-found-paketler/` +
            `${ilIdForPaket}/` +
            `${ilceIdForPaket}/` +
            `${mahalleIdForPaket}/` +
            `${csbmIdForPaket}/` +
            `${binaIdForPaket}/` +
            `${fiberVarMiValue}/` +
            `${vdslVarMiValue}/` +
            `${adslVarMiValue}/`+
            `${telekomFiberMaxSupportedSpeed}/` +
            `${telekomVdslMaxSupportedSpeed}/` +
            `${telekomAdslMaxSupportedSpeed}`;

        // 🚀 YÖNLENDİR
        window.location.href = url;
    });

    issAltyapiPaketlerBtn.addEventListener('click', () => {

        const ilIdForPaket       = Number(il.value);
        const ilceIdForPaket     = Number(ilce.value);
        const mahalleIdForPaket  = Number(mahalle.value);
        const csbmIdForPaket     = Number(csbm.value);
        const binaIdForPaket     = Number(bina.value);

        // 🔒 Güvenlik kontrolü
        if (
            !ilIdForPaket ||
            !ilceIdForPaket ||
            !mahalleIdForPaket ||
            !csbmIdForPaket ||
            !binaIdForPaket
        ) {
            alert('Adres bilgileri eksik');
            return;
        }

        // 🔵 ISS ROUTE (SADE)
        const url =
            `/altyapi-sorgu-found-paketler/iss/` +
            `${ilIdForPaket}/` +
            `${ilceIdForPaket}/` +
            `${mahalleIdForPaket}/` +
            `${csbmIdForPaket}/` +
            `${binaIdForPaket}`;

        // 🚀 YÖNLENDİR
        window.location.href = url;
    });




    function setFoundPaketlerButtonLabel(id, isFiberVarMi, isVdslVarMi, isAdslVarMi){
        const el = document.getElementById(id);
        if (!el) return;
        if(isFiberVarMi === true || isVdslVarMi === true || isAdslVarMi === true){
            el.innerText = 'Paketleri Görüntüle →' ;
        }else{
            el.innerText = 'Paket Bulunamadı !'
        }

        el.className =
            isFiberVarMi === true || isVdslVarMi === true || isAdslVarMi === true
                ? 'block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-4 transition'
                : 'block w-full text-center bg-red-500 hover:bg-red-600 text-white font-bold py-4 transition';

        // 🔒 TEK HAREKET: tıklamayı kapat / aç
        el.style.pointerEvents =
            isFiberVarMi === true || isVdslVarMi === true || isAdslVarMi === true
                ? 'auto'
                : 'none';
    }


    function setBaglantiTuruLabel(id, val, isVarMi){
     const el = document.getElementById(id);
     if (!el) return;
     el.innerText = val ;
     el.className =
         isVarMi === true
             ? 'bg-green-400 text-center font-bold py-2 text-white'
             : 'bg-red-400 text-center font-bold py-2 text-white';
 }

    function setBaglantiTuruText(id, val) {
        const el = document.getElementById(id);
        if (!el) return;

        if (!val || val === 'Hizmet Verilememektedir') return;

        el.innerText = val;
    }

    function setText(id, val , isVarMi) {
        const el = document.getElementById(id);
        if (!el) return;
        el.innerText = val ;
        el.className =
            isVarMi === true
                ? 'bg-green-500 text-white px-2 py-1 rounded'
                : 'bg-red-500 text-white px-2 py-1 rounded';
    }
    function setBadgeForIssAltyapi(id, val) {
        const el = document.getElementById(id);
        if (!el) return;

        el.innerText = val === true ? 'Var':'Yok';
        el.className =
            val === true
                ? 'bg-green-500 text-white px-2 py-1 rounded'
                : 'bg-red-500 text-white px-2 py-1 rounded';
    }

    function setBadge(id, val) {
        const el = document.getElementById(id);
        if (!el) return;

        el.innerText = val;
        el.className =
            val === 'Var'
                ? 'bg-green-500 text-white px-2 py-1 rounded'
                : 'bg-red-500 text-white px-2 py-1 rounded';
    }

    function setSpeed(id, speed) {
        const el = document.getElementById(id);
        if (!el) return;

        el.innerText = speed + ' Mbps';
        el.className =
            speed > 0
                ? 'bg-green-500 text-white px-2 py-1 rounded'
                : 'bg-red-500 text-white px-2 py-1 rounded';
    }


    let gaugeInstance = null;
    function initGauge(gauge_speed) {
        /* =========================
           KONFİGÜRASYON
        ========================== */

        // Backend’den gelecek hız değeri
        const speed = gauge_speed;

        // ADSL | VDSL | FIBER


        // Maksimum hız
        const maxSpeed = 1000;

        /* =========================
           LABEL VE ZON AYARLARI
        ========================== */

        const labels = [0, 100, 250, 500, 750, 1000];

        const zones = [
            { strokeStyle: "#ef4444", min: 0,   max: 50 },   // Çok düşük
            { strokeStyle: "#f59e0b", min: 50,  max: 100 },  // Orta
            { strokeStyle: "#22c55e", min: 100, max: 1000 }  // İyi / Fiber
        ];

        /* =========================
           GAUGE OPSİYONLARI
        ========================== */

        const opts = {
            angle: -0.2,
            lineWidth: 0.18,
            radiusScale: 0.9,

            pointer: {
                length: 0.6,
                strokeWidth: 0.04,
                color: "#111"
            },

            staticLabels: {
                font: "12px sans-serif",
                labels: labels,
                color: "#111",
                fractionDigits: 0
            },

            staticZones: zones,

            limitMax: false,
            limitMin: false,
            highDpiSupport: true
        };

        /* =========================
           GAUGE OLUŞTURMA
        ========================== */

        const target = document.getElementById("speedGauge");

        if (!gaugeInstance) {
            gaugeInstance = new Gauge(target).setOptions(opts);
            gaugeInstance.setMinValue(0);
            gaugeInstance.maxValue = maxSpeed;
            gaugeInstance.animationSpeed = 35;
        }

        gaugeInstance.set(speed ?? 0);

        /* =========================
           METİN GÜNCELLEME
        ========================== */

        const speedText = speed !== null ? speed : 0;

       if(speed > 0){
           document.getElementById("speedValue").innerText = `${speedText} Mbps`;
       }else{
           document.getElementById("speedValue").innerText = `Hizmet Verilememektedir`;
       }


    }

    const choiceInstances = {};

    function initChoice(id) {
        if (choiceInstances[id]) {
            choiceInstances[id].destroy();
        }

        choiceInstances[id] = new Choices(`#${id}`, {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
            placeholder: true,
            placeholderValue: 'Seçiniz...',
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        [
            'il',
            'ilce',
            'bucak',
            'mahalle',
            'csbm',
            'bina',
            'ickapi'
        ].forEach(initChoice);




    });

    // Sayfa açıldığında ISS seçili olsun
    document.addEventListener('DOMContentLoaded', () => {
        altyapiToggle.checked = false;
        applyToggleState();
    });

</script>
@endpush

</body>
</html>

