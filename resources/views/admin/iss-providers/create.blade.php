@extends('layouts.admin')

@section('title', 'Yeni ISS Sağlayıcı Ekle')
@section('page-title', 'Yeni ISS Sağlayıcı Ekle')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.iss-providers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Ad --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ad *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                           placeholder="durunet"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Logo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo URL</label>
                    <input type="text" name="logo_path" value="{{ old('logo_path') }}"
                           placeholder="iss-company-logos/durunet.png"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Konum --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konum</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           placeholder="Antalya"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Şirket Bilgisi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Şirket Bilgisi</label>
                    <textarea name="company_info" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('company_info') }}</textarea>
                </div>

                {{-- Çağrı Merkezi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Çağrı Merkezi</label>
                    <input type="text" name="cagrimerkezi" value="{{ old('cagrimerkezi') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp No</label>
                    <input type="text" name="whatsapp_no" value="{{ old('whatsapp_no') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Faks --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Faks</label>
                    <input type="text" name="fax" value="{{ old('fax') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- E-posta --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                    <input type="text" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Website --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                    <input type="text" name="website" value="{{ old('website') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Ünvan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ünvan</label>
                    <input type="text" name="unvan" value="{{ old('unvan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Adres --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
                    <textarea name="address" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                </div>

                {{-- Hizmet Türleri --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hizmet Türleri
                    </label>

                    <div class="flex flex-wrap gap-6">
                        @php
                            $oldServices = old('services')
                                ? explode("\n", old('services'))
                                : [];
                        @endphp

                        @foreach (['ADSL', 'VDSL', 'FIBER'] as $service)
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    value="{{ $service }}"
                                    class="service-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    {{ in_array($service, $oldServices) ? 'checked' : '' }}
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

                    <p class="text-xs text-gray-500 mt-2">
                        Bir veya birden fazla hizmet türü seçebilirsiniz
                    </p>
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

                        $oldCities = old('service_areas')
                            ? explode("\n", old('service_areas'))
                            : [];
                    @endphp

                    <div class="border rounded-lg h-56 overflow-y-auto p-3 space-y-2 bg-gray-50">
                        @foreach ($turkeyCities as $city)
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input
                                    type="checkbox"
                                    value="{{ $city }}"
                                    class="city-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    {{ in_array($city, $oldCities) ? 'checked' : '' }}
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

                    <p class="text-xs text-gray-500 mt-2">
                        Hizmet verilen şehirleri seçebilirsiniz
                    </p>
                </div>


            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Kaydet
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

        document.querySelectorAll('.service-checkbox').forEach(el => {
            el.addEventListener('change', syncServicesTextarea);
        });

        function syncServiceAreasTextarea() {
            const checked = Array.from(
                document.querySelectorAll('.city-checkbox:checked')
            ).map(el => el.value);

            document.getElementById('service-areas-hidden').value = checked.join("\n");
        }

        document.querySelectorAll('.city-checkbox').forEach(el => {
            el.addEventListener('change', syncServiceAreasTextarea);
        });

        // sayfa ilk açıldığında senkronla
        syncServicesTextarea();
        syncServiceAreasTextarea();


        // sayfa ilk açıldığında senkronla


    </script>

@endsection
