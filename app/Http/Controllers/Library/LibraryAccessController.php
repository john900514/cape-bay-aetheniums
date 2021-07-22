<?php

namespace App\Http\Controllers\Library;

use App\Actions\Aetheniums\Content\GenerateContentLayout;
use App\Actions\Dashboards\Developer\GetCnBLibraryDashboardViewData;
use App\Actions\Dashboards\Developer\GetGenericLibraryDashboardViewData;
use App\Actions\Dashboards\Developer\GetHomeDashboardViewData;
use App\Http\Controllers\Controller;
use App\Models\Content\Page;
use App\Models\LibraryOfBabble\Article;
use App\Models\LibraryOfBabble\Library;
use App\Models\LibraryOfBabble\Project;
use App\Models\LibraryOfBabble\Topic;
use Illuminate\Http\Request;

class LibraryAccessController extends Controller
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

    public function cnb_library_access()
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.cape-and-bay.'.backpack_user()->getRoles()[0].'-library-dashboard';
                    $data  = GetCnBLibraryDashboardViewData::run(backpack_user()->id);
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

    public function trufit_library_access()
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.trufit.'.backpack_user()->getRoles()[0].'-library-dashboard';
                    $data = [
                        'page_shown' => 'libraries',
                        'active_client' => '25f6972a-c0e5-43a5-adfc-cf58b4f8c189',
                        'library_id' => '988decb9-eb60-4315-bbbc-6ba8e0f906c4'
                    ];
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

    public function generic_library_access($slug)
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.generic.'.backpack_user()->getRoles()[0].'-library-dashboard';
                    $data  = GetGenericLibraryDashboardViewData::run(backpack_user()->id, $slug);
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

    public function trufit_project_access($project, Project $projects, Library $libraries)
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.trufit.'.backpack_user()->getRoles()[0].'-projects-dashboard';

                    $project_record = $projects->whereListingRoute('/library/projects/trufit/'.$project)->first();

                    if(!is_null($project_record))
                    {
                        $library_record = $libraries->find($project_record->library_id);

                        if(!is_null($library_record))
                        {
                            $data = [
                                'page_shown' => 'projects',
                                'active_client' => '25f6972a-c0e5-43a5-adfc-cf58b4f8c189',
                                'library_id' => $project_record->library_id,
                                'project_id' => $project_record->id,
                                'library' => $library_record->toArray(),
                                'project' => $project_record->toArray()
                            ];
                        }
                        else
                        {
                            // @todo - error scenario bad library
                        }
                    }
                    else
                    {
                        // @todo - error scenario bad project
                    }
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

    public function cnb_project_access($project, Project $projects, Library $libraries)
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.cape-and-bay.'.backpack_user()->getRoles()[0].'-projects-dashboard';

                    $project_record = $projects->whereListingRoute('/library/projects/cnb/'.$project)->first();

                    if(!is_null($project_record))
                    {
                        $library_record = $libraries->find($project_record->library_id);

                        if(!is_null($library_record))
                        {
                            $data = [
                                'page_shown' => 'projects',
                                'active_client' => '',
                                'library_id' => $project_record->library_id,
                                'project_id' => $project_record->id,
                                'library' => $library_record->toArray(),
                                'project' => $project_record->toArray()
                            ];
                        }
                        else
                        {
                            // @todo - error scenario bad library
                        }
                    }
                    else
                    {
                        // @todo - error scenario bad project
                    }
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

    public function generic_project_access($library, $project, Project $projects, Library $libraries)
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.generic.'.backpack_user()->getRoles()[0].'-projects-dashboard';

                    $project_record = $projects->whereListingRoute('/library/projects/'.$library.'/'.$project)->first();

                    if(!is_null($project_record))
                    {
                        $library_record = $libraries->find($project_record->library_id);

                        if(!is_null($library_record))
                        {
                            $data = [
                                'page_shown' => 'projects',
                                'active_client' => '',
                                'library_id' => $project_record->library_id,
                                'project_id' => $project_record->id,
                                'library' => $library_record->toArray(),
                                'project' => $project_record->toArray()
                            ];
                        }
                        else
                        {
                            // @todo - error scenario bad library
                        }
                    }
                    else
                    {
                        // @todo - error scenario bad project
                    }
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

    public function cnb_topic_access($project, Topic $topics, Project $projects, Library $libraries)
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.cape-and-bay.'.backpack_user()->getRoles()[0].'-topics-dashboard';

                    if($this->request->has('topic'))
                    {
                        $topic_record = $topics->whereId($this->request->get('topic'))
                            ->with('articles')->first();
                        if(!is_null($topic_record))
                        {
                            $project_record = $projects->whereListingRoute('/library/projects/cnb/'.$project)->first();

                            if(!is_null($project_record))
                            {
                                if($topic_record->project_id == $project_record->id)
                                {
                                    $library_record = $libraries->find($project_record->library_id);

                                    if(!is_null($library_record))
                                    {
                                        $articles = [];

                                        foreach($topic_record->articles as $article)
                                        {
                                            $page_post = $article->page_post();
                                            $article = $article->toArray();
                                            $article['page_post'] = $page_post;
                                            $articles[] = $article;
                                        }

                                        $data = [
                                            'page_shown' => 'topics',
                                            'active_client' => '',
                                            'topic_id' => $topic_record->id,
                                            'library_id' => $project_record->library_id,
                                            'project_id' => $project_record->id,
                                            'library' => $library_record->toArray(),
                                            'project' => $project_record->toArray(),
                                            'topic' => $topic_record->toArray(),
                                            'articles' => $articles
                                        ];
                                    }
                                    else
                                    {
                                        // @todo - error scenario bad library
                                    }
                                }
                                else
                                {
                                    // @todo - error scenario mismatched project/topic
                                    $blade = 'errors.501';
                                }
                            }
                            else
                            {
                                // @todo - error scenario bad project
                            }
                        }
                        else
                        {
                            // @todo - error scenario bad topic_id
                        }
                    }
                    else
                    {
                        // A topic property is required in the url
                        $blade = 'errors.500';
                    }
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

    public function trufit_topic_access($project, Topic $topics, Project $projects, Library $libraries)
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.trufit.'.backpack_user()->getRoles()[0].'-topics-dashboard';

                    if($this->request->has('topic'))
                    {
                        $topic_record = $topics->whereId($this->request->get('topic'))
                            ->with('articles')->first();

                        if(!is_null($topic_record))
                        {
                            $project_record = $projects->whereListingRoute('/library/projects/trufit/'.$project)->first();

                            if(!is_null($project_record))
                            {
                                if($topic_record->project_id == $project_record->id)
                                {
                                    $library_record = $libraries->find($project_record->library_id);

                                    if(!is_null($library_record))
                                    {
                                        $articles = [];

                                        foreach($topic_record->articles as $article)
                                        {
                                            $page_post = $article->page_post();
                                            $article = $article->toArray();
                                            $article['page_post'] = $page_post;
                                            $articles[] = $article;
                                        }

                                        $data = [
                                            'page_shown' => 'topics',
                                            'active_client' => '',
                                            'topic_id' => $topic_record->id,
                                            'library_id' => $project_record->library_id,
                                            'project_id' => $project_record->id,
                                            'library' => $library_record->toArray(),
                                            'project' => $project_record->toArray(),
                                            'topic' => $topic_record->toArray(),
                                            'articles' => $articles
                                        ];
                                    }
                                    else
                                    {
                                        // @todo - error scenario bad library
                                    }
                                }
                                else
                                {
                                    // @todo - error scenario mismatched project/topic
                                    $blade = 'errors.501';
                                }
                            }
                            else
                            {
                                // @todo - error scenario bad project
                            }
                        }
                        else
                        {
                            // @todo - error scenario bad topic_id
                        }
                    }
                    else
                    {
                        // A topic property is required in the url
                        $blade = 'errors.500';
                    }
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

    public function generic_topic_access($library, $project, Topic $topics, Project $projects, Library $libraries)
    {
        $data = [];

        try {
            switch(backpack_user()->getRoles()[0])
            {
                case 'developer':
                    $blade = 'library.dashboards.generic.'.backpack_user()->getRoles()[0].'-topics-dashboard';

                    if($this->request->has('topic'))
                    {
                        $topic_record = $topics->whereId($this->request->get('topic'))
                            ->with('articles')->first();

                        if(!is_null($topic_record))
                        {
                            $project_record = $projects->whereListingRoute('/library/projects/'.$library.'/'.$project)->first();

                            if(!is_null($project_record))
                            {
                                if($topic_record->project_id == $project_record->id)
                                {
                                    $library_record = $libraries->find($project_record->library_id);

                                    if(!is_null($library_record))
                                    {
                                        $articles = [];

                                        foreach($topic_record->articles as $article)
                                        {
                                            $page_post = $article->page_post();
                                            $article = $article->toArray();
                                            $article['page_post'] = $page_post;
                                            $articles[] = $article;
                                        }

                                        $data = [
                                            'page_shown' => 'topics',
                                            'active_client' => '',
                                            'topic_id' => $topic_record->id,
                                            'library_id' => $project_record->library_id,
                                            'project_id' => $project_record->id,
                                            'library' => $library_record->toArray(),
                                            'project' => $project_record->toArray(),
                                            'topic' => $topic_record->toArray(),
                                            'articles' => $articles
                                        ];
                                    }
                                    else
                                    {
                                        // @todo - error scenario bad library
                                    }
                                }
                                else
                                {
                                    // @todo - error scenario mismatched project/topic
                                    $blade = 'errors.501';
                                }
                            }
                            else
                            {
                                // @todo - error scenario bad project
                            }
                        }
                        else
                        {
                            // @todo - error scenario bad topic_id
                        }
                    }
                    else
                    {
                        // A topic property is required in the url
                        $blade = 'errors.500';
                    }
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

    public function view_specific_article($project_slug, $article_id, Article $articles, Page $pages)
    {
        $data = [
            'view' => backpack_view('blank'),
            'page_shown' => 'articles',
        ];

        if($this->request->has('slug'))
        {
            $article = $articles->whereId($article_id)
                ->with('topic')
                ->first();

            $post = $pages->whereSlug($this->request->get('slug'))->first();

            if(true)
            {
                $blade = 'library.templates.'.$post->template;

                // Get the article's topic, project and library
                $topic   = $article['topic'];
                $project = $topic['project'];
                $library = $project['library'];

                // Populate the breadcrumb data Library -> Project -> Topic -> Article
                $data['breadcrumbs'] = [
                    $library['name'] => url($library['listing_route']),
                    $project['name'] => url($project['listing_route']),
                    $topic['name']   => url($topic['listing_route']),
                    $post->name      => false
                ];

                // Curate boilerplate date for all templates
                $data['title'] = $post->title;
                $data['subheading'] = $article->desc;
                $data['go_back_url'] = url($topic['listing_route']).'?topic='.$topic['id'];
                $data['go_back_text'] = $topic['name'];
                $data['project_id'] = $project['id'];

                // Generate the Template Specific Data
                $data['content'] = GenerateContentLayout::run($post);
            }
            else
            {
                $blade = 'errors.401';
            }
        }
        else
        {
            $blade = 'errors.404';
        }

        return view($blade, $data);
    }

    public function view_article($library, $project_slug, $article_id, Article $articles, Page $pages)
    {
        $data = [
            'view' => backpack_view('blank'),
            'page_shown' => 'articles',
        ];

        if($this->request->has('slug'))
        {
            $article = $articles->whereId($article_id)
                ->with('topic')
                ->first();

            $post = $pages->whereSlug($this->request->get('slug'))->first();

            if(true)
            {
                $blade = 'library.templates.'.$post->template;

                // Get the article's topic, project and library
                
                $topic   = $article['topic'];
                $project = $topic['project'];
                $library = $project['library'];

                // Populate the breadcrumb data Library -> Project -> Topic -> Article
                $data['breadcrumbs'] = [
                    $library['name'] => url($library['listing_route']),
                    $project['name'] => url($project['listing_route']),
                    $topic['name']   => url($topic['listing_route']),
                    $post->name      => false
                ];

                // Curate boilerplate date for all templates
                $data['title'] = $post->title;
                $data['subheading'] = $article->desc;
                $data['go_back_url'] = url($topic['listing_route']).'?topic='.$topic['id'];
                $data['go_back_text'] = $topic['name'];
                $data['project_id'] = $project['id'];

                // Generate the Template Specific Data
                $data['content'] = GenerateContentLayout::run($post);
            }
            else
            {
                $blade = 'errors.401';
            }
        }
        else
        {
            $blade = 'errors.404';
        }

        return view($blade, $data);
    }
}
