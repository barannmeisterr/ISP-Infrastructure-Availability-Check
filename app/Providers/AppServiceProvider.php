<?php
/**
Author:Arda Baran
*/
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\IssServiceArea;
use App\Models\Package;
use App\Models\IssProvider;
use App\Observers\IssServiceAreaObserver;
use App\Observers\IssPackageObserver;
use App\Observers\IssCompanyObserver;
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        IssServiceArea::observe(IssServiceAreaObserver::class);
        Package::observe(IssPackageObserver::class);
        IssProvider::observe(IssCompanyObserver::class);
    }
}

