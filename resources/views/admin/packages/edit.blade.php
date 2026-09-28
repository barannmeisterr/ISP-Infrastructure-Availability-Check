@extends('layouts.admin')

@section('title', 'Paket Düzenle')
@section('page-title', 'Paket Düzenle: ' . $package->title)

@section('content')

    <div class="mb-4">
        <a href="{{ route('admin.packages.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Geri Dön
        </a>
    </div>

    {{-- ================= ANA FORM ================= --}}
    <form action="{{ route('admin.packages.update', $package) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- ISS --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">ISS Sağlayıcı *</label>
                    <select name="iss_provider_id" required class="w-full px-4 py-2 border rounded-lg">
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}"
                                {{ $package->iss_provider_id == $provider->id ? 'selected' : '' }}>
                                {{ $provider->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Başlık --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Başlık *</label>
                    <input type="text" name="title" required
                           value="{{ $package->title }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- XDSL --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Altyapı Türü *</label>
                    <select name="xdsltype" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="1" {{ $package->xdsltype == 1 ? 'selected' : '' }}>ADSL</option>
                        <option value="6" {{ $package->xdsltype == 6 ? 'selected' : '' }}>VDSL</option>
                        <option value="7" {{ $package->xdsltype == 7 ? 'selected' : '' }}>FIBER</option>
                    </select>
                </div>

                {{-- Fiyat --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Fiyat (₺)</label>
                    <input type="number" step="0.01" min="0"
                           name="price"
                           value="{{ $package->price }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Download --}}
                <div>
                    <label class="block text-sm font-medium mb-2">İndirme (Mbps)</label>
                    <input type="number" min="0"
                           name="download"
                           value="{{ $package->download }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Upload --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Yükleme (Mbps)</label>
                    <input type="number" min="0"
                           name="upload"
                           value="{{ $package->upload }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Açıklama --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Açıklama</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 border rounded-lg">{{ $package->description }}</textarea>
                </div>


            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Güncelle
                </button>
                <a href="{{ route('admin.packages.index') }}" class="bg-gray-200 px-6 py-2 rounded-lg">
                    İptal
                </a>
            </div>

        </div>
    </form>

    {{-- ================= CSV İLE YENİ HİZMET BÖLGESİ EKLE ================= --}}
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <form action="{{ route('admin.packages.import-areas', $package) }}"
              method="POST"
              enctype="multipart/form-data"
              onsubmit="return confirm('CSV içindeki bölgeler mevcutlara EKLENECEK. Emin misiniz?');">
            @csrf

            <h3 class="font-semibold text-lg mb-3 flex items-center gap-2">
                📍 CSV ile Yeni Hizmet Bölgeleri Ekle
            </h3>

            <div class="flex flex-wrap items-center gap-4">

                {{-- GİZLİ FILE INPUT --}}
                <input
                    type="file"
                    name="areas_csv"
                    id="areas_csv"
                    accept=".csv"
                    required
                    class="hidden"
                    onchange="document.getElementById('file-name').innerText = this.files[0]?.name ?? 'Dosya seçilmedi';"
                >

                {{-- DOSYA SEÇ BUTONU --}}
                <label for="areas_csv"
                       class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-lg
                          border border-gray-300 bg-gray-50 hover:bg-gray-100
                          text-sm font-medium text-gray-700 transition">
                    📁 Dosya Seç
                </label>

                {{-- DOSYA ADI --}}
                <span id="file-name" class="text-sm text-gray-500">
                Dosya seçilmedi
            </span>

                {{-- YÜKLE BUTONU --}}
                <button type="submit"
                        class="inline-flex items-center gap-2
                           bg-green-600 hover:bg-green-700
                           text-white px-5 py-2 rounded-lg
                           text-sm font-semibold transition">
                    ⬆️ Yükle
                </button>
            </div>

            <p class="text-xs text-gray-500 mt-3">
                ℹ️ Mevcut alanlar silinmez, CSV’deki satırlar pakete eklenir.
            </p>

            <div class="mt-3">
                <a href="{{ route('admin.packages.csv-template') }}"
                   class="inline-flex items-center gap-2 text-sm text-blue-600 hover:underline">
                    📄 CSV Şablonunu İndir
                </a>
            </div>
        </form>
    </div>





@endsection
