<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - IssAltyapı</title>
    @vite('resources/css/app.css')
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/location-pin.png') }}" class="h-8" alt="">
                    <span class="text-xl font-bold">
                        Iss<span class="text-blue-400">Altyapı</span>
                    </span>
                </a>
                <p class="text-sm text-gray-400 mt-1">Admin Panel</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.iss-providers.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.iss-providers.*') ? 'bg-gray-700' : '' }}">
                    <span>🏢</span>
                    <span>ISS Sağlayıcılar</span>
                </a>
                
                <a href="{{ route('admin.packages.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.packages.*') ? 'bg-gray-700' : '' }}">
                    <span>📦</span>
                    <span>Paketler</span>
                </a>
                
                <a href="{{ route('admin.home-settings.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.home-settings.*') ? 'bg-gray-700' : '' }}">
                    <span>⚙️</span>
                    <span>Ana Sayfa Ayarları</span>
                </a>
            </nav>
            
            <div class="p-4 border-t border-gray-700">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                    <span>🏠</span>
                    <span>Ana Sayfaya Dön</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Admin Panel')</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">Admin</span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
