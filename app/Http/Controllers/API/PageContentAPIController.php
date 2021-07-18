<?php

namespace App\Http\Controllers\API;

use App\Services\PageContentHelperDoodad;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Silber\Bouncer\BouncerFacade as Bouncer;

class PageContentAPIController extends Controller
{
    protected $request, $page_content_service;

    public function __construct(Request $request, PageContentHelperDoodad $pages_svc)
    {
        $this->request = $request;
        $this->page_content_service = $pages_svc;
    }

    public function index()
    {
        $code = 200;
        $results = [];

        if($this->request->has('articles') && ($this->request->get('articles') == true))
        {
            $templates = $this->page_content_service->getTemplatesDesignedForArticles();
        }
        else
        {
            $templates = $this->page_content_service->getAllTemplates();
        }

        if(count($templates) > 0)
        {
            $pages = $this->page_content_service->getPagesWithTheseTemplates($templates);

            if(count($pages) > 0)
            {
                // check for as dropdown or just send back raw
                if($this->request->has('asSelectData') && ($this->request->get('asSelectData') == true))
                {
                    $results = $this->page_content_service->getAllPagesAsDropDown($pages);
                }
                else
                {
                    $results = $pages;
                }
            }
        }

        return response($results, $code);
    }
}
