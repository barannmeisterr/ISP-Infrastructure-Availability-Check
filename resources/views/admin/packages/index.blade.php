@extends('layouts.admin')

@section('title', 'Paketler')
@section('page-title', 'Paketler')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Tüm Paketler</h2>
        <a href="{{ route('admin.packages.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            ➕ Yeni Ekle
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Başlık</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sağlayıcı</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tür</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hız</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fiyat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">İşlemler</th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($packages as $package)
                @php
                    $xdslMap = config('xdsl');
                    $typeLabel = $xdslMap[$package->xdsltype] ?? 'Bilinmiyor';

                    $typeColor = match($package->xdsltype) {
                        7 => 'bg-green-100 text-green-800', // FIBER
                        6 => 'bg-blue-100 text-blue-800',  // VDSL
                        1 => 'bg-gray-100 text-gray-800', // ADSL
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp

                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $package->title }}
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            {{ $package->provider->name ?? '-' }}
                        </div>
                    </td>

                    <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $typeColor }}">
                        {{ $typeLabel }}
                    </span>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            {{ $package->download }} / {{ $package->upload }} Mbps
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-900">
                            {{ number_format($package->price, 2) }} ₺
                        </div>
                    </td>

                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                        <a href="{{ route('admin.packages.show', $package) }}"
                           class="text-blue-600 hover:text-blue-900 mr-3">Görüntüle</a>

                        <a href="{{ route('admin.packages.edit', $package) }}"
                           class="text-indigo-600 hover:text-indigo-900 mr-3">Düzenle</a>

                        <form action="{{ route('admin.packages.destroy', $package) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Bu paketi silmek istediğinizden emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-900">
                                Sil
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Henüz paket eklenmemiş.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $packages->links() }}
        </div>
    </div>
@endsection
