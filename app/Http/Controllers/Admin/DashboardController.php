<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Dashboards\Developer\GetHomeDashboardViewData;
use App\Models\Clubs\Club;
use App\Models\Customers\Leads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Silber\Bouncer\BouncerFacade as Bouncer;

class DashboardController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.'.backpack_user()->getRoles()[0].'-dashboard';
                    $data  = GetHomeDashboardViewData::run(backpack_user()->id);
                    break;

                case 'admin':
                case 'ad-ops':
                case 'executive':
                case 'gm':
                default:
                    $blade = 'errors.401';
            }
        }
        catch(\Exception $e)
        {
            $blade = 'errors.404';
        }

        return view($blade, $data);
    }
}
