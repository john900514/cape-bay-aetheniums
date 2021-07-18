<?php

namespace App\Actions\Sidebars;

use App\Models\LibraryOfBabble\Library;
use App\Models\LibraryOfBabble\Project;
use Lorisleiva\Actions\Concerns\AsAction;
use Silber\Bouncer\BouncerFacade as Bouncer;

class GetProjectsSidebaroptions
{
    use AsAction;

    public function handle($library_id = null)
    {
        $results = [];

        $libs = Project::whereActive(1);

        if(is_null($library_id))
        {
            $libs = $libs->whereNull('library_id');
        }
        else
        {
            $libs = $libs->whereLibraryId($library_id);
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
