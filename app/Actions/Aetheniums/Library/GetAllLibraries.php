<?php

namespace App\Actions\Aetheniums\Library;

use App\Models\LibraryOfBabble\Library;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllLibraries
{
    use AsAction;

    public function handle(bool $include_projects = false, bool $include_topics = false, bool $include_articles = false)
    {
        $results = [];

        $libraries = Library::whereActive(1);

        if($include_projects && (!$include_topics))
        {
            $libraries = $libraries->with('projects');
        }
        elseif($include_projects && $include_topics)
        {
            if($include_articles)
            {
                $libraries = $libraries->with('projects_with_topics_and_articles');
            }
            else
            {
                $libraries = $libraries->with('projects_with_topics');
            }
        }

        $libraries = $libraries->get();

        if(count($libraries) > 0)
        {
            foreach ($libraries as $idx => $library)
            {
                if(!is_null($library->permitted_role))
                {
                    /*
                    if(!is_null($library->permitted_abilities))
                    {

                    }
                    */
                    // @todo - eval for sending back projects, and topics and articles with each library
                }
                elseif(!is_null($library->permitted_abilities))
                {
                    // @todo - eval for sending back projects, and topics and articles with each library
                }
                else
                {
                    $results[$idx] = $library->toArray();
                    // @todo - eval for sending back projects, and topics and articles with each library
                }
            }
        }

        return $results;
    }
}
