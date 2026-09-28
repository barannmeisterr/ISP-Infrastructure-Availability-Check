@extends('layouts.admin')

@section('title', 'ISS Sağlayıcı Düzenle')
@section('page-title', 'ISS Sağlayıcı Düzenle: ' . $issProvider->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.iss-providers.index') }}"
           class="text-blue-600 hover:text-blue-800">← Geri Dön</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.iss-providers.update', $issProvider) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Ad --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ad *</label>
                    <input type="text" name="name"
                           value="{{ old('name', $issProvider->name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug"
                           value="{{ old('slug', $issProvider->slug) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Logo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo URL</label>
                    <input type="text" name="logo_path"
                           value="{{ old('logo_path', $issProvider->logo_path) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Konum --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konum</label>
                    <input type="text" name="location"
                           value="{{ old('location', $issProvider->location) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Şirket Bilgisi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Şirket Bilgisi</label>
                    <textarea name="company_info" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('company_info', $issProvider->company_info) }}</textarea>
                </div>

                {{-- Çağrı Merkezi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Çağrı Merkezi</label>
                    <input type="text" name="cagrimerkezi"
                           value="{{ old('cagrimerkezi', $issProvider->cagrimerkezi) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp No</label>
                    <input type="text" name="whatsapp_no"
                           value="{{ old('whatsapp_no', $issProvider->whatsapp_no) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Faks --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Faks</label>
                    <input type="text" name="fax"
                           value="{{ old('fax', $issProvider->fax) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- E-posta --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                    <input type="email" name="email"
                           value="{{ old('email', $issProvider->email) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Website --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                    <input type="text" name="website"
                           value="{{ old('website', $issProvider->website) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Ünvan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ünvan</label>
                    <input type="text" name="unvan"
                           value="{{ old('unvan', $issProvider->unvan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Adres --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
                    <textarea name="address" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address', $issProvider->address) }}</textarea>
                </div>

                {{-- Hizmet Türleri --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hizmet Türleri
                    </label>

                    @php
                        $selectedServices = [];

                        if ($issProvider->services) {
                            $decoded = json_decode($issProvider->services, true);
                            if (is_array($decoded)) {
                                $selectedServices = $decoded;
                            }
                        }

                        // validation hatası varsa onu ezsin
                        if (old('services')) {
                            $selectedServices = explode("\n", old('services'));
                        }
                    @endphp

                    <div class="flex flex-wrap gap-6">
                        @foreach (['ADSL', 'VDSL', 'FIBER'] as $service)
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    value="{{ $service }}"
                                    class="service-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    {{ in_array($service, $selectedServices) ? 'checked' : '' }}
                                >
                                <span>{{ $service }}</span>
                            </label>
                        @endforeach
                    </div>

                    {{-- controller uyumu için hidden textarea --}}
                    <textarea
                        name="services"
                        id="services-hidden"
                        class="hidden"
                    ></textarea>
                </div>


                {{-- Hizmet Verilen Şehirler --}}
                {{-- Hizmet Verilen Şehirler --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hizmet Verilen Şehirler
                    </label>

                    @php
                        $turkeyCities = [
                 'Adana',
'Adıyaman',
'Afyonkarahisar',
'Ağrı',
'Aksaray',
'Amasya',
'Ankara',
'Antalya',
'Ardahan',
'Artvin',
'Aydın',
'Balıkesir',
'Bartın',
'Batman',
'Bayburt',
'Bilecik',
'Bingöl',
'Bitlis',
'Bolu',
'Burdur',
'Bursa',
'Çanakkale',
'Çankırı',
'Çorum',
'Denizli',
'Diyarbakır',
'Düzce',
'Edirne',
'Elazığ',
'Erzincan',
'Erzurum',
'Eskişehir',
'Gaziantep',
'Giresun',
'Gümüşhane',
'Hakkari',
'Hatay',
'Iğdır',
'Isparta',
'İstanbul',
'İzmir',
'Kahramanmaraş',
'Karabük',
'Karaman',
'Kars',
'Kastamonu',
'Kayseri',
'Kırıkkale',
'Kırklareli',
'Kırşehir',
'Kilis',
'Kocaeli',
'Konya',
'Kütahya',
'Malatya',
'Manisa',
'Mardin',
'Mersin',
'Muğla',
'Muş',
'Nevşehir',
'Niğde',
'Ordu',
'Osmaniye',
'Rize',
'Sakarya',
'Samsun',
'Siirt',
'Sinop',
'Sivas',
'Şanlıurfa',
'Şırnak',
'Tekirdağ',
'Tokat',
'Trabzon',
'Tunceli',
'Uşak',
'Van',
'Yalova',
'Yozgat',
'Zonguldak'
                        ];

                        $selectedCities = $issProvider->serviceAreas
                            ->pluck('city')
                            ->toArray();

                        // validation hatası varsa onu ezsin
                        if (old('service_areas')) {
                            $selectedCities = explode("\n", old('service_areas'));
                        }
                    @endphp

                    <div class="border rounded-lg h-56 overflow-y-auto p-3 space-y-2 bg-gray-50">
                        @foreach ($turkeyCities as $city)
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input
                                    type="checkbox"
                                    value="{{ $city }}"
                                    class="city-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    {{ in_array($city, $selectedCities) ? 'checked' : '' }}
                                >
                                <span>{{ $city }}</span>
                            </label>
                        @endforeach
                    </div>

                    {{-- controller uyumu için hidden textarea --}}
                    <textarea
                        name="service_areas"
                        id="service-areas-hidden"
                        class="hidden"
                    ></textarea>
                </div>


            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Güncelle
                </button>

                <a href="{{ route('admin.iss-providers.index') }}"
                   class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                    İptal
                </a>
            </div>

        </form>
    </div>
    <script>
        function syncServicesTextarea() {
            const checked = Array.from(
                document.querySelectorAll('.service-checkbox:checked')
            ).map(el => el.value);

            document.getElementById('services-hidden').value = checked.join("\n");
        }

        function syncServiceAreasTextarea() {
            const checked = Array.from(
                document.querySelectorAll('.city-checkbox:checked')
            ).map(el => el.value);

            document.getElementById('service-areas-hidden').value = checked.join("\n");
        }

        document.querySelectorAll('.service-checkbox').forEach(el => {
            el.addEventListener('change', syncServicesTextarea);
        });

        document.querySelectorAll('.city-checkbox').forEach(el => {
            el.addEventListener('change', syncServiceAreasTextarea);
        });

        // sayfa ilk açıldığında
        syncServicesTextarea();
        syncServiceAreasTextarea();
    </script>

@endsection
