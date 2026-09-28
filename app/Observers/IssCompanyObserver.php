<?php
/**
Author:Arda Baran
*/
namespace App\Observers;

use App\Models\IssProvider;
use App\Models\HomeStat;
class IssCompanyObserver
{
    protected function updateCompanyStat(): void
    {
        $companyCount = IssProvider::distinct('id')->count('id');

        HomeStat::updateOrCreate(
            ['label' => 'İnternet Servis Sağlayıcı'],
            [
                'count' => $companyCount,
                'order' => 2,
            ]
        );
    }

    public function created(IssProvider $provider)
    {
        $this->updateCompanyStat();
    }

    public function deleted(IssProvider $provider)
    {
        $this->updateCompanyStat();
    }

    public function updated(IssProvider $provider)
    {
        $this->updateCompanyStat();
    }
}

