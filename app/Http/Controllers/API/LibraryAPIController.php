<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\DirectoryThingie;
use App\Http\Controllers\Controller;
use Silber\Bouncer\BouncerFacade as Bouncer;

class LibraryAPIController extends Controller
{
    protected $request, $library_service;

    public function __construct(Request $request, DirectoryThingie $lib_svc)
    {
        $this->request = $request;
        $this->library_service = $lib_svc;
    }

    public function index()
    {
        $code = 200;

        backpack_auth()->login(auth()->user());
        $authorized_user = Bouncer::is(backpack_user())->an('admin', 'developer');
        $authorized_ability = false; //backpack_user()->can('access_lob_api') && backpack_user()->can('access_libraries');
        // check if user is (admin or developer), or (can access api + access libraries via api)
        if($authorized_user || $authorized_ability)
        {
            // @todo - eval data for instructions and send to action.
            $include_projects  = ($this->request->has('projects') && ($this->request->get('projects') == true));
            $include_topics    = ($this->request->has('topics')   && ($this->request->get('topics') == true));
            $include_articles  = ($this->request->has('articles') && ($this->request->get('articles') == true));
            $directory_thingie = $this->library_service->initAvailableLibraries($include_projects, $include_topics, $include_articles);

            // check for as dropdown or just send back raw
            if($this->request->has('asSelectData') && ($this->request->get('asSelectData') == true))
            {
                $results = $directory_thingie->getAllLibrariesAsDropDown();
            }
            else
            {
                $results = $directory_thingie->getAllLibrariesInArray();
            }
        }
        else
        {
            $code = 401;
        }



        return response($results, $code);
    }
}
