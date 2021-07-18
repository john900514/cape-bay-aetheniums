<?php

namespace App\Actions\Aetheniums\Content;

use App\Actions\Aetheniums\Content\Templates\GetMailChimpArticleSchema;
use App\Actions\Aetheniums\Content\Templates\GetTwilioArticleSchema;
use App\Models\Content\Page;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateContentLayout
{
    use AsAction;

    public function handle(Page $page)
    {
        $results = [];

        // use the page's template to get the template rules
        switch($page->template)
        {
            case 'twilio_style_article':
                $results = GetTwilioArticleSchema::run($page->extras);
                break;

            case 'mailchimp_style_article':
                $results = GetMailChimpArticleSchema::run($page->extras);
                break;
        }

        return $results;
    }
}
