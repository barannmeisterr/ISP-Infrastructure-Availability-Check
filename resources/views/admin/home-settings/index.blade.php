@extends('layouts.admin')

@section('title', 'Ana Sayfa Ayarları')
@section('page-title', 'Ana Sayfa Ayarları')

@section('content')
<div class="space-y-6">
    <!-- İstatistikler -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ana Sayfa İstatistikleri</h2>
        <form action="{{ route('admin.home-settings.update-stats') }}" method="POST" id="statsForm">
            @csrf
            <div id="statsContainer" class="space-y-4">
                @foreach($stats as $index => $stat)
                    <div class="flex gap-4 items-end border-b pb-4 stat-row">
                        <input type="hidden" name="stats[{{ $index }}][id]" value="{{ $stat->id }}">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sayı</label>
                            <input type="number" name="stats[{{ $index }}][count]" value="{{ $stat->count }}" min="0" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Etiket</label>
                            <input type="text" name="stats[{{ $index }}][label]" value="{{ $stat->label }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="w-24">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sıra</label>
                            <input type="number" name="stats[{{ $index }}][order]" value="{{ $stat->order }}" min="0" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="button" onclick="removeStatRow(this)" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Sil</button>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex gap-4">
                <button type="button" onclick="addStatRow()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                    ➕ Yeni İstatistik Ekle
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Kaydet
                </button>
            </div>
        </form>
    </div>

    <!-- Öne Çıkarılan ISS Sağlayıcılar -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Öne Çıkarılan ISS Sağlayıcılar</h2>
        <div class="mb-4">
            <form action="{{ route('admin.home-settings.add-provider') }}" method="POST" class="flex gap-4">
                @csrf
                <select name="iss_provider_id" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">ISS Sağlayıcı Seçiniz...</option>
                    @foreach($allProviders as $provider)
                        @if(!$highlightedProviders->contains('iss_provider_id', $provider->id))
                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                        @endif
                    @endforeach
                </select>
                <input type="number" name="sort_order" value="{{ $highlightedProviders->max('sort_order') + 1 }}" min="0" required
                       class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Sıra">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Ekle
                </button>
            </form>
        </div>
        <div class="space-y-2">
            @forelse($highlightedProviders as $highlighted)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500">#{{ $highlighted->sort_order }}</span>
                        <span class="font-semibold text-gray-800">{{ $highlighted->provider->name }}</span>
                    </div>
                    <form action="{{ route('admin.home-settings.remove-provider', $highlighted->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Kaldırmak istediğinizden emin misiniz?')">Kaldır</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Henüz öne çıkarılan ISS sağlayıcı yok</p>
            @endforelse
        </div>
    </div>

    <!-- Öne Çıkarılan Paketler -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Öne Çıkarılan Paketler</h2>
        <div class="mb-4">
            <form action="{{ route('admin.home-settings.add-package') }}" method="POST" class="flex gap-4">
                @csrf
                <select name="package_id" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Paket Seçiniz...</option>
                    @foreach($allPackages as $package)
                        @if(!$highlightedPackages->contains('package_id', $package->id))
                            <option value="{{ $package->id }}">{{ $package->title }} ({{ $package->provider->name ?? '-' }})</option>
                        @endif
                    @endforeach
                </select>
                <input type="number" name="sort_order" value="{{ $highlightedPackages->max('sort_order') + 1 }}" min="0" required
                       class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Sıra">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Ekle
                </button>
            </form>
        </div>
        <div class="space-y-2">
            @forelse($highlightedPackages as $highlighted)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500">#{{ $highlighted->sort_order }}</span>
                        <div>
                            <span class="font-semibold text-gray-800">{{ $highlighted->package->title }}</span>
                            <span class="text-sm text-gray-600 ml-2">({{ $highlighted->package->provider->name ?? '-' }})</span>
                        </div>
                    </div>
                    <form action="{{ route('admin.home-settings.remove-package', $highlighted->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Kaldırmak istediğinizden emin misiniz?')">Kaldır</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Henüz öne çıkarılan paket yok</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
let statIndex = {{ $stats->count() }};

function addStatRow() {
    const container = document.getElementById('statsContainer');
    const row = document.createElement('div');
    row.className = 'flex gap-4 items-end border-b pb-4 stat-row';
    row.innerHTML = `
        <input type="hidden" name="stats[${statIndex}][id]" value="">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sayı</label>
            <input type="number" name="stats[${statIndex}][count]" value="0" min="0" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Etiket</label>
            <input type="text" name="stats[${statIndex}][label]" value="" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="w-24">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sıra</label>
            <input type="number" name="stats[${statIndex}][order]" value="${statIndex}" min="0" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="button" onclick="removeStatRow(this)" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Sil</button>
    `;
    container.appendChild(row);
    statIndex++;
}

function removeStatRow(button) {
    button.closest('.stat-row').remove();
}
</script>
@endpush
@endsection
