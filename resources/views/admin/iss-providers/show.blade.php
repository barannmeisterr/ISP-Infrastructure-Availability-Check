@extends('layouts.admin')

@section('title', $issProvider->name)
@section('page-title', $issProvider->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.iss-providers.index') }}"
           class="text-blue-600 hover:text-blue-800">← Geri Dön</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">

        {{-- Header --}}
        <div class="flex justify-between items-start mb-6">
            <div class="flex items-center gap-4">
                @if($issProvider->logo_path)
                    <img src="{{ asset($issProvider->logo_path) }}"
                         alt="{{ $issProvider->name }}"
                         class="h-16 w-auto object-contain">
                @endif

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $issProvider->name }}
                    </h2>
                    <p class="text-gray-600 text-sm">
                        Slug: {{ $issProvider->slug }}
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.iss-providers.edit', $issProvider) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Düzenle
            </a>
        </div>

        {{-- İçerik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Konum --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Konum</h3>
                <p class="text-gray-600">{{ $issProvider->location ?? '-' }}</p>
            </div>

            {{-- Hizmet Türleri --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Hizmet Türleri</h3>

                <div class="flex flex-wrap gap-2">
                    @php
                        $services = [];

                        if ($issProvider->services) {
                            if (is_array($issProvider->services)) {
                                $services = $issProvider->services;
                            } else {
                                $decoded = json_decode($issProvider->services, true);
                                $services = is_array($decoded)
                                    ? $decoded
                                    : explode("\n", $issProvider->services);
                            }
                        }
                    @endphp

                    @forelse($services as $service)
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        {{ trim($service) }}
                    </span>
                    @empty
                        <span class="text-gray-500">-</span>
                    @endforelse
                </div>
            </div>

            {{-- Şirket Bilgisi --}}
            @if($issProvider->company_info)
                <div class="md:col-span-2">
                    <h3 class="font-semibold text-gray-700 mb-2">Şirket Bilgisi</h3>
                    <p class="text-gray-600 whitespace-pre-line">
                        {{ $issProvider->company_info }}
                    </p>
                </div>
            @endif

            {{-- İletişim --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">İletişim</h3>
                <div class="space-y-1 text-gray-600">
                    @if($issProvider->cagrimerkezi) <p>📞 {{ $issProvider->cagrimerkezi }}</p> @endif
                    @if($issProvider->whatsapp_no) <p>💬 {{ $issProvider->whatsapp_no }}</p> @endif
                    @if($issProvider->fax) <p>📠 {{ $issProvider->fax }}</p> @endif
                    @if($issProvider->email) <p>✉️ {{ $issProvider->email }}</p> @endif
                    @if($issProvider->website) <p>🌐 {{ $issProvider->website }}</p> @endif
                </div>
            </div>

            {{-- Adres --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Şirket Ünvan & Adres</h3>
                <div class="space-y-1 text-gray-600">
                    @if($issProvider->unvan)
                        <p><strong>Ünvan:</strong> {{ $issProvider->unvan }}</p>
                    @endif
                    @if($issProvider->address)
                        <p><strong>Adres:</strong> {{ $issProvider->address }}</p>
                    @endif
                </div>
            </div>

            {{-- Hizmet Verilen Şehirler --}}
            <div class="md:col-span-2">
                <h3 class="font-semibold text-gray-700 mb-2">
                    Hizmet Verilen Şehirler ({{ $issProvider->serviceAreas->count() }})
                </h3>

                <div class="flex flex-wrap gap-2">
                    @forelse($issProvider->serviceAreas as $area)
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                        {{ $area->city }}
                    </span>
                    @empty
                        <span class="text-gray-500">Henüz şehir eklenmemiş</span>
                    @endforelse
                </div>
            </div>

            {{-- Paketler --}}
            <div class="md:col-span-2">
                <h3 class="font-semibold text-gray-700 mb-2">
                    Paketler ({{ $issProvider->packages->count() }})
                </h3>

                @if($issProvider->packages->count() > 0)
                    <div class="space-y-2">
                        @foreach($issProvider->packages as $package)
                            <a href="{{ route('admin.packages.show', $package) }}"
                               class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $package->title }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $package->download }} / {{ $package->upload }}
                                        </p>
                                    </div>
                                    <span class="text-lg font-bold text-blue-600">
                                    {{ $package->price }} ₺
                                </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Henüz paket eklenmemiş</p>
                @endif
            </div>

        </div>
    </div>
@endsection
