<?php
/**
Author:Arda Baran
*/
namespace App\Observers;

use App\Models\IssServiceArea;
use App\Models\HomeStat;

class IssServiceAreaObserver
{
    protected function updateCityStat(): void
    {
        $cityCount = IssServiceArea::distinct('city')->count('city');

        HomeStat::updateOrCreate(
            ['label' => 'Şehir'],
            [
                'count' => $cityCount,
                'order' => 3,
            ]
        );
    }

    public function created(IssServiceArea $area)
    {
        $this->updateCityStat();
    }

    public function deleted(IssServiceArea $area)
    {
        $this->updateCityStat();
    }

    public function updated(IssServiceArea $area)
    {
        $this->updateCityStat();
    }
}
