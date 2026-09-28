@extends('layouts.admin')

@section('title', $package->title)
@section('page-title', $package->title)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.packages.index') }}" class="text-blue-600 hover:text-blue-800">← Geri Dön</a>
    </div>

    @php
        $xdslMap = config('xdsl');
        $typeLabel = $xdslMap[$package->xdsltype] ?? 'Bilinmiyor';

        $typeColor = match($package->xdsltype) {
            7 => 'bg-green-100 text-green-800',
            6 => 'bg-blue-100 text-blue-800',
            1 => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    @endphp

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $package->title }}</h2>
                <p class="text-gray-600">
                    Sağlayıcı: {{ $package->provider->name ?? '-' }}
                </p>
            </div>

            <a href="{{ route('admin.packages.edit', $package) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Düzenle
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Tür --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Altyapı Türü</h3>
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $typeColor }}">
                    {{ $typeLabel }}
                </span>
            </div>

            {{-- Fiyat --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Fiyat</h3>
                <p class="text-2xl font-bold text-blue-600">
                    {{ number_format($package->price, 2) }} ₺
                </p>
            </div>

            {{-- Download --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">İndirme Hızı</h3>
                <p class="text-gray-600">{{ $package->download }} Mbps</p>
            </div>

            {{-- Upload --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Yükleme Hızı</h3>
                <p class="text-gray-600">{{ $package->upload }} Mbps</p>
            </div>

            {{-- Ping --}}
            @if($package->ping)
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Ping</h3>
                    <p class="text-gray-600">{{ $package->ping }}</p>
                </div>
            @endif

            {{-- Özellikler --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Özellikler</h3>
                <div class="space-y-1 text-gray-600">
                    <p>
                        <strong>Taahhüt:</strong>
                        {{ $package->commitment ? 'Var' : 'Yok' }}
                        @if($package->commitment && $package->commitment_month)
                            ({{ $package->commitment_month }} ay)
                        @endif
                    </p>
                    <p>
                        <strong>Kota:</strong>
                        {{ $package->quota ? 'Var' : 'Yok' }}
                    </p>
                </div>
            </div>

            {{-- Açıklama --}}
            @if($package->description)
                <div class="md:col-span-2">
                    <h3 class="font-semibold text-gray-700 mb-2">Açıklama</h3>
                    <p class="text-gray-600">{{ $package->description }}</p>
                </div>
            @endif

            {{-- ================= HİZMET ALANLARI ================= --}}
            <div class="md:col-span-2">
                <h3 class="font-semibold text-gray-700 mb-2">
                    Bu Paketin Kullanılabileceği Bölgeler ({{ $areas->total() }})
                </h3>

                @if($areas->isEmpty())
                    <p class="text-gray-500">Henüz hizmet alanı eklenmemiş.</p>
                @else
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-3 py-2">Şehir</th>
                                <th class="px-3 py-2">İl</th>
                                <th class="px-3 py-2">İlçe</th>
                                <th class="px-3 py-2">Mahalle</th>
                                <th class="px-3 py-2">CSBM</th>
                                <th class="px-3 py-2">Bina</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y">
                            @foreach($areas as $area)
                                <tr>
                                    <td class="px-3 py-2 font-medium text-gray-800">{{ $area->city }}</td>
                                    <td class="px-3 py-2">{{ $area->il_id ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $area->ilce_id ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $area->mahalle_id ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $area->csbm_id ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $area->bina_id ?? '-' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{-- Pagination --}}
                    <div
                        class="flex justify-between items-center mt-3"
                        id="pagination"
                        data-current-page="{{ $areas->currentPage() }}"
                        data-last-page="{{ $areas->lastPage() }}"
                        data-total="{{ $areas->total() }}"
                    >
    <span class="text-sm">
        Toplam <span id="total-count">{{ $areas->total() }}</span> kayıt
    </span>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                id="prevPage"
                                class="px-3 py-1 border rounded disabled:opacity-40"
                            >←</button>

                            <span class="text-sm">
            Sayfa <span id="currentPage">{{ $areas->currentPage() }}</span>
            /
            <span id="totalPages">{{ $areas->lastPage() }}</span>
        </span>

                            <button
                                type="button"
                                id="nextPage"
                                class="px-3 py-1 border rounded disabled:opacity-40"
                            >→</button>
                        </div>
                    </div>

                @endif
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('pagination');
            if (!wrapper) return;

            const currentPage = parseInt(wrapper.dataset.currentPage);
            const lastPage = parseInt(wrapper.dataset.lastPage);

            const prevBtn = document.getElementById('prevPage');
            const nextBtn = document.getElementById('nextPage');

            // Disable butonlar
            if (currentPage <= 1) prevBtn.disabled = true;
            if (currentPage >= lastPage) nextBtn.disabled = true;

            // URL'den parametreleri koru
            const getUrl = (page) => {
                const url = new URL(window.location.href);
                url.searchParams.set('page', page);
                return url.toString();
            };

            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    window.location.href = getUrl(currentPage - 1);
                }
            });

            nextBtn.addEventListener('click', () => {
                if (currentPage < lastPage) {
                    window.location.href = getUrl(currentPage + 1);
                }
            });
        });
    </script>

@endsection
