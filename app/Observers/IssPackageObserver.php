<?php
/**
Author:Arda Baran
*/
namespace App\Observers;
use App\Models\Package;
use App\Models\HomeStat;
class IssPackageObserver
{
    protected function updatePackageStat(): void
    {
        $packageCount = Package::distinct('id')->count('id');

        HomeStat::updateOrCreate(
            ['label' => 'İnternet Paketi'],
            [
                'count' => $packageCount,
                'order' => 1,
            ]
        );
    }

    public function created(Package $package)
    {
        $this->updatePackageStat();
    }

    public function deleted(Package $package)
    {
        $this->updatePackageStat();
    }

    public function updated(Package $package)
    {
        $this->updatePackageStat();
    }
}
