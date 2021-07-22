<?php

namespace App\Actions\Dashboards\Developer;

use App\Models\LibraryOfBabble\Library;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGenericLibraryDashboardViewData
{
    use AsAction;

    public function handle(string $user_id, string $slug)
    {
        $results = [
            'page_shown' => 'libraries',

        ];

        $lib_model = Library::where('misc->slug', '=', $slug)->first();
        $results['library_id'] = $lib_model->id;
        $results['library_name'] = $lib_model->name;


        return $results;
    }
}
