<?php

namespace App\Actions\Auth;

use Lorisleiva\Actions\Concerns\AsAction;

class SendBackToAnchor
{
    use AsAction;

    public function handle()
    {
        $user = backpack_user();

        if(is_null($user))
        {
            return redirect(config('nautical.anchor_cms_url'));
        }
        else
        {
            return redirect('/library');
        }
    }
}
