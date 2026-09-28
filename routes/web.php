<?php
/**
Author:Arda Baran
*/
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Controllers\UavtAdresController;
use App\Http\Controllers\AltyapiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\PackageController as FrontendPackageController;
use App\Http\Controllers\Frontend\IssProviderController as FrontendIssProviderController;
use App\Http\Controllers\Frontend\AltyapiSorguController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\IssProviderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\HomeSettingsController;
Route::prefix('uavt')->group(function () {

    Route::get('/iller', [UavtAdresController::class, 'iller']);

    Route::get('/ilceler/{il_id}', [UavtAdresController::class, 'ilceler']);

    Route::get('/bucaklar/{ilce_id}', [UavtAdresController::class, 'bucaklar']);

    Route::get('/mahalleler/{bucak_id}', [UavtAdresController::class, 'mahalleler']);

    Route::get('/sokaklar/{mahalle_id}', [UavtAdresController::class, 'sokaklar']);

    Route::get('/binalar/{sokak_id}', [UavtAdresController::class, 'binalar']);

    Route::get('/daireler/{bina_id}', [UavtAdresController::class, 'daireler']);

});
Route::prefix('altyapi')->group(function () {
    Route::get('/altyapiHizmetSorgu/{bbk}', [AltyapiController::class, 'getAltyapiServicesByBBK']);
});
Route::get(
    '/altyapi/iss-altyapi-sorgu/{il}/{ilce}/{mahalle}/{csbm}/{bina}',
    [AltyapiController::class, 'getAltyapiServicesForIssHizmetBolgeleri']
);

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');



Route::post(
    '/admin/packages/{package}/import-areas',
    [PackageController::class, 'importAreasFromCsvForEdit']
)->name('admin.packages.import-areas');


Route::get(
    '/admin/packages/csv-template',
    [PackageController::class, 'downloadAreasCsvTemplate']
)->name('admin.packages.csv-template');

// Admin Routes (korumalı)
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // ISS Providers
    Route::resource('iss-providers', IssProviderController::class);

    // ISS Provider – Paketleri Çek
    Route::post(
        'iss-providers/{issProvider}/fetch-packages',
        [IssProviderController::class, 'fetchPackages']
    )->name('iss-providers.fetch-packages');


    // Packages
    Route::resource('packages', PackageController::class);

    // Home Settings
    Route::get('/home-settings', [HomeSettingsController::class, 'index'])->name('home-settings.index');
    Route::post('/home-settings/stats', [HomeSettingsController::class, 'updateStats'])->name('home-settings.update-stats');
    Route::post('/home-settings/highlighted-providers', [HomeSettingsController::class, 'addHighlightedProvider'])->name('home-settings.add-provider');
    Route::delete('/home-settings/highlighted-providers/{id}', [HomeSettingsController::class, 'removeHighlightedProvider'])->name('home-settings.remove-provider');
    Route::post('/home-settings/highlighted-packages', [HomeSettingsController::class, 'addHighlightedPackage'])->name('home-settings.add-package');
    Route::delete('/home-settings/highlighted-packages/{id}', [HomeSettingsController::class, 'removeHighlightedPackage'])->name('home-settings.remove-package');
});

Route::get('/altyapi-sorgulama', fn () => view('altyapi_sorgu'))->name('altyapi_sorgu');

// Ana Sayfa
Route::get('/', [HomeController::class, 'index'])->name('home');
// Frontend Routes
Route::get('/paketler', [FrontendPackageController::class, 'index'])->name('paketler');
Route::get('/paket/{id}', [FrontendPackageController::class, 'show'])->name('paket.show');

Route::get('/internet-saglayicilari', [FrontendIssProviderController::class, 'index'])->name('saglayicilar');
Route::get('/internet-saglayicilari/{slug}', [FrontendIssProviderController::class, 'show'])->name('saglayici.show');

Route::get('/destek', fn () => view('destek'))->name('destek');

Route::get(
    '/altyapi-sorgu-found-paketler/{ilId}/{ilceId}/{mahalleId}/{csbmId}/{binaId}/{fiber}/{vdsl}/{adsl}/{fiberSpeed}/{vdslSpeed}/{adslSpeed}',
    [AltyapiSorguController::class, 'foundPackagesForTurkTelekom']
)->name('altyapi_sorgu_found_paketler');

Route::get(
    '/altyapi-sorgu-found-paketler/iss/{ilId}/{ilceId}/{mahalleId}/{csbmId}/{binaId}',
    [AltyapiSorguController::class, 'foundPackagesForIssAltyapi']
)->name('altyapi_sorgu_found_paketler_iss');
