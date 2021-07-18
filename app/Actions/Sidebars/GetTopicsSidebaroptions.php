<?php

namespace App\Actions\Sidebars;

use App\Models\LibraryOfBabble\Library;
use App\Models\LibraryOfBabble\Project;
use App\Models\LibraryOfBabble\Topic;
use Lorisleiva\Actions\Concerns\AsAction;
use Silber\Bouncer\BouncerFacade as Bouncer;

class GetTopicsSidebaroptions
{
    use AsAction;

    public function handle($project_id = null)
    {
        $results = [];

        $libs = Topic::whereActive(1);

        if(is_null($project_id))
        {
            $libs = $libs->whereNull('project_id');
        }
        else
        {
            $libs = $libs->whereProjectId($project_id);
        }

        $libs = $libs->get();

        if(count($libs) > 0)
        {
            foreach($libs as $lib)
            {
                if(!is_null($lib->permitted_role))
                {
                    if(Bouncer::is(backpack_user())->a($lib->permitted_role))
                    {
                        if(!is_null($lib->permitted_abilities))
                        {
                            if(backpack_user()->can($lib->permitted_abilities))
                            {
                                $results[] = $lib->toArray();
                            }
                        }
                        else
                        {
                            $results[] = $lib->toArray();
                        }
                    }
                }
                elseif(!is_null($lib->permitted_abilities))
                {
                    if(backpack_user()->can($lib->permitted_abilities))
                    {
                        $results[] = $lib->toArray();
                    }
                }
                else
                {
                    $results[] = $lib->toArray();
                }
            }
        }

        return $results;
    }
}
