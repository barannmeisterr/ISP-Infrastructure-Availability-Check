@extends('layouts.admin')

@section('title', 'Yeni Paket Ekle')
@section('page-title', 'Yeni Paket Ekle')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.packages.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- ISS --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">ISS Sağlayıcı *</label>
                    <select name="iss_provider_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Seçiniz...</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}"
                                {{ old('iss_provider_id') == $provider->id ? 'selected' : '' }}>
                                {{ $provider->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Başlık --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Başlık *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- XDSL --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Altyapı Türü *</label>
                    <select name="xdsltype" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="1">ADSL</option>
                        <option value="6">VDSL</option>
                        <option value="7">FIBER</option>
                    </select>
                </div>

                {{-- Fiyat --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Fiyat (₺) *</label>
                    <input type="number" name="price" step="0.01" min="0" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Download --}}
                <div>
                    <label class="block text-sm font-medium mb-2">İndirme (Mbps) *</label>
                    <input type="number" name="download" min="0" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Upload --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Yükleme (Mbps) *</label>
                    <input type="number" name="upload" min="0" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Ping --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Ping</label>
                    <input type="text" name="ping"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Taahhüt --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Taahhüt (Ay)</label>
                    <input type="number" name="commitment_month" min="1"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                {{-- Checkboxlar --}}
                <div class="flex items-center gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="commitment" value="1">
                        <span class="ml-2">Taahhüt Var</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="quota" value="1">
                        <span class="ml-2">Kota Var</span>
                    </label>
                </div>

                {{-- Açıklama --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Açıklama</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>

                {{-- 🔥 MANUEL SERVICE AREAS --}}
                <div class="md:col-span-2">
                    <label class="block font-medium mb-2">Paket Hizmet Bölgeleri (Manuel)</label>

                    <div id="areas-wrapper" class="space-y-3">

                        {{-- SATIR 0 --}}
                        <div class="grid grid-cols-7 gap-2 items-center">
                            <input type="text"
                                   name="areas[0][city]"
                                   placeholder="Şehir *"
                                   class="col-span-2 px-3 py-2 border rounded-lg">

                            <input type="number"
                                   name="areas[0][il_id]"
                                   placeholder="İl Kodu"
                                   class="px-3 py-2 border rounded-lg">

                            <input type="number"
                                   name="areas[0][ilce_id]"
                                   placeholder="İlçe Kodu"
                                   class="px-3 py-2 border rounded-lg">

                            <input type="number"
                                   name="areas[0][mahalle_id]"
                                   placeholder="Mahalle Kodu"
                                   class="px-3 py-2 border rounded-lg">

                            <input type="number"
                                   name="areas[0][csbm_id]"
                                   placeholder="CSBM"
                                   class="px-3 py-2 border rounded-lg">

                            <input type="number"
                                   name="areas[0][bina_id]"
                                   placeholder="Bina"
                                   class="px-3 py-2 border rounded-lg">
                        </div>

                    </div>

                    <button type="button"
                            onclick="addArea()"
                            class="mt-3 text-sm text-blue-600 hover:underline">
                        ➕ Alan Ekle
                    </button>

                    <p class="text-xs text-gray-500 mt-1">
                        CSV yüklerseniz manuel alanlar otomatik devre dışı kalır.
                    </p>
                </div>


                {{-- 🔥 CSV UPLOAD (GÜZELLEŞTİRİLMİŞ) --}}
                <div class="md:col-span-2 border-t pt-4">
                    <label class="block font-medium mb-2">📥 CSV ile Paket Hizmet Bölgelerini Yükle</label>

                    <div class="flex items-center gap-4">
                        <button type="button"
                                onclick="document.getElementById('areas_csv').click()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            📁 CSV Dosyası Seç
                        </button>

                        <span id="csv-file-name" class="text-sm text-gray-600">
                        Dosya seçilmedi
                    </span>
                    </div>

                    <input type="file"
                           name="areas_csv"
                           id="areas_csv"
                           accept=".csv"
                           class="hidden"
                           onchange="onCsvSelected(this)">

                    <p class="text-xs text-gray-500 mt-2">
                        Kolonlar:
                        <code>city, il_id, ilce_id, mahalle_id, csbm_id, bina_id</code>
                    </p>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.packages.csv-template') }}"
                   class="inline-flex items-center gap-2 text-sm text-blue-600 hover:underline">
                    📄 CSV Örnek Şablon İndir
                </a>
            </div>


            <div class="mt-6 flex gap-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Kaydet
                </button>

                <a href="{{ route('admin.packages.index') }}"
                   class="bg-gray-200 px-6 py-2 rounded-lg">
                    İptal
                </a>
            </div>
        </form>
    </div>

    <script>
        let areaIndex = 1;

        function addArea() {
            const wrapper = document.getElementById('areas-wrapper');

            const row = document.createElement('div');
            row.className = 'grid grid-cols-7 gap-2 items-center';

            row.innerHTML = `
            <input type="text"
                   name="areas[${areaIndex}][city]"
                   placeholder="Şehir *"
                   class="col-span-2 px-3 py-2 border rounded-lg"
                   required>

            <input type="number"
                   name="areas[${areaIndex}][il_id]"
                   placeholder="İl Kodu"
                   class="px-3 py-2 border rounded-lg">

            <input type="number"
                   name="areas[${areaIndex}][ilce_id]"
                   placeholder="İlçe Kodu"
                   class="px-3 py-2 border rounded-lg">

            <input type="number"
                   name="areas[${areaIndex}][mahalle_id]"
                   placeholder="Mahalle Kodu"
                   class="px-3 py-2 border rounded-lg">

            <input type="number"
                   name="areas[${areaIndex}][csbm_id]"
                   placeholder="CSBM"
                   class="px-3 py-2 border rounded-lg">

            <input type="number"
                   name="areas[${areaIndex}][bina_id]"
                   placeholder="Bina"
                   class="px-3 py-2 border rounded-lg">
        `;

            wrapper.appendChild(row);
            areaIndex++;
        }

        function onCsvSelected(input) {
            const label = document.getElementById('csv-file-name');

            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.classList.add('text-green-700', 'font-medium');

                // 🔥 manuel alanları kapat
                document.querySelectorAll('.area-input').forEach(el => {
                    el.disabled = true;
                    el.classList.add('bg-gray-100');
                });
            } else {
                label.textContent = 'Dosya seçilmedi';
            }
        }
    </script>
@endsection
