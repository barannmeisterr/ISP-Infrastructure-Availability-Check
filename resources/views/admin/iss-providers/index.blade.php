@extends('layouts.admin')

@section('title', 'ISS Sağlayıcılar')
@section('page-title', 'ISS Sağlayıcılar')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Tüm ISS Sağlayıcılar</h2>

        <a href="{{ route('admin.iss-providers.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            ➕ Yeni Ekle
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Konum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hizmet Verdiği Şehirler</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">İşlemler</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($providers as $provider)
                    <tr class="hover:bg-gray-50">

                        {{-- Logo --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($provider->logo_path)
                                <img src="{{ asset($provider->logo_path) }}"
                                     alt="{{ $provider->name }}"
                                     class="h-10 w-auto object-contain">
                            @else
                                <span class="text-gray-400 italic">Yok</span>
                            @endif
                        </td>

                        {{-- Ad --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $provider->name }}
                            </div>
                        </td>

                        {{-- Slug --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $provider->slug }}
                            </div>
                        </td>

                        {{-- Konum --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $provider->location ?? '-' }}
                            </div>
                        </td>

                        {{-- Hizmet Alanı --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600">
                                {{ $provider->service_areas_count }} şehir
                            </span>
                        </td>


                        {{-- İşlemler --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-3">

                                {{-- Sol taraf: linkler --}}
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.iss-providers.show', $provider) }}"
                                       class="text-blue-600 hover:text-blue-900">
                                        Görüntüle
                                    </a>

                                    <a href="{{ route('admin.iss-providers.edit', $provider) }}"
                                       class="text-indigo-600 hover:text-indigo-900">
                                        Düzenle
                                    </a>

                                    <form action="{{ route('admin.iss-providers.destroy', $provider) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Bu ISS sağlayıcıyı silmek istediğinizden emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900">
                                            Sil
                                        </button>
                                    </form>
                                </div>

                                {{-- Sağ taraf: Paketleri Çek --}}
                                <form action="{{ route('admin.iss-providers.fetch-packages', $provider) }}"
                                      method="POST"
                                      class="ml-auto"
                                      onsubmit="return confirm('Bu ISS için paketler otomatik çekilecek. Emin misiniz?');">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-2
                           bg-green-600 text-white
                           px-4 py-2 rounded-lg
                           hover:bg-green-700 transition
                           text-sm font-semibold">
                                        📦 Paketleri Çek
                                    </button>
                                </form>

                            </div>
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Henüz ISS sağlayıcı eklenmemiş.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $providers->links() }}
        </div>
    </div>
@endsection
