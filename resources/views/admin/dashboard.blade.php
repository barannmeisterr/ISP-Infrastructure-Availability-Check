@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Toplam ISS Sağlayıcı</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\IssProvider::count() }}</p>
            </div>
            <div class="text-4xl">🏢</div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Toplam Paket</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Package::count() }}</p>
            </div>
            <div class="text-4xl">📦</div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Ana Sayfa İstatistikleri</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\HomeStat::count() }}</p>
            </div>
            <div class="text-4xl">📊</div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Hızlı İşlemler</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('admin.iss-providers.create') }}" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
            <span class="text-2xl">➕</span>
            <div>
                <p class="font-semibold text-gray-800">Yeni ISS Sağlayıcı Ekle</p>
                <p class="text-sm text-gray-600">Yeni bir internet servis sağlayıcı ekle</p>
            </div>
        </a>
        
        <a href="{{ route('admin.packages.create') }}" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
            <span class="text-2xl">➕</span>
            <div>
                <p class="font-semibold text-gray-800">Yeni Paket Ekle</p>
                <p class="text-sm text-gray-600">Yeni bir internet paketi ekle</p>
            </div>
        </a>
        
        <a href="{{ route('admin.home-settings.index') }}" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
            <span class="text-2xl">⚙️</span>
            <div>
                <p class="font-semibold text-gray-800">Ana Sayfa Ayarları</p>
                <p class="text-sm text-gray-600">İstatistikler ve öne çıkarılanlar</p>
            </div>
        </a>
        
        <a href="/" target="_blank" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
            <span class="text-2xl">👁️</span>
            <div>
                <p class="font-semibold text-gray-800">Ana Sayfayı Görüntüle</p>
                <p class="text-sm text-gray-600">Yeni sekmede aç</p>
            </div>
        </a>
    </div>
</div>
@endsection
