<?php

namespace App\Actions\Dashboards\Developer;

use Lorisleiva\Actions\Concerns\AsAction;

class GetCnBLibraryDashboardViewData
{
    use AsAction;

    public function handle()
    {
        $results = [
            'page_shown' => 'libraries',
        ];

        return $results;
    }
}
