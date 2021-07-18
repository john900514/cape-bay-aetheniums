<?php

namespace App\Actions\Dashboards\Developer;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Silber\Bouncer\BouncerFacade as Bouncer;

class GetHomeDashboardViewData
{
    use AsAction;

    public function handle(string $developer_id)
    {
        $data = [];
        $user = User::find($developer_id);

        if(Bouncer::is($user)->a('developer'))
        {
            $data['heading'] = 'Welcome to our Library of Babble, '.$user->name.'!';
            $data['content'] = 'We build this knowledge base to be the definitive source for everything Cape & Bay. Learn how our projects work, reference an SDK to complete a ticket, or contribute by creating articles for your team, other staff or even yourself. <br /><br />The choice is yours, friend.';
        }

        return $data;
    }
}
