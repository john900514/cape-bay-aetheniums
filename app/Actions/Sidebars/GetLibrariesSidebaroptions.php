<?php

namespace App\Actions\Sidebars;

use App\Models\LibraryOfBabble\Library;
use Lorisleiva\Actions\Concerns\AsAction;
use Silber\Bouncer\BouncerFacade as Bouncer;

class GetLibrariesSidebaroptions
{
    use AsAction;

    public function handle()
    {
        $results = [];

        $libs = Library::whereActive(1)->get();

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
