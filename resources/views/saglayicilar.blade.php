@extends('layouts.app')

@section('content')
<!-- HERO -->
<section class="py-28">
    <div class="max-w-6xl mx-auto text-center px-6">


        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            Tüm İnternet Hizmet Sağlayıcıları
        </h1>



        <p class="text-gray-600 text-lg max-w-3xl mx-auto">
            IssAltyapı bünyesinde hizmet veren tüm internet sağlayıcıları.
        </p>

    </div>
</section>
<form method="GET" class="mb-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto">

        <!-- İSİME GÖRE -->
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="ISS adına göre ara"
            class="border rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500"
        >

        <!-- ŞEHRE GÖRE -->
        <select
            name="city"
            class="border rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500"
        >
            <option value="">Tüm Şehirler</option>

            @foreach($cities as $city)
                <option
                    value="{{ $city }}"
                    {{ $selectedCity === $city ? 'selected' : '' }}
                >
                    {{ $city }}
                </option>
            @endforeach
        </select>

        <button
            type="submit"
            class="bg-blue-600 text-white font-semibold rounded-lg px-6 py-3 hover:bg-blue-700 transition"
        >
            Ara
        </button>

    </div>
</form>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($issler as $iss)
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
