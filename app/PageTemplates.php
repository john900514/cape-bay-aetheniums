<?php

namespace App;

use App\Actions\Aetheniums\Content\Templates\Definitions\GetMailchimpArticleFieldDefinitions;
use App\Actions\Aetheniums\Content\Templates\Definitions\GetTwilioArticleFieldDefinitions;

trait PageTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Page Templates for Backpack\PageManager
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    | - page name (only seen by admins)
    | - page title
    | - page slug
    */
    private function twilio_style_article()
    {
        $this->parseFields(GetTwilioArticleFieldDefinitions::run());
    }

    private function mailchimp_style_article()
    {
        $this->parseFields(GetMailchimpArticleFieldDefinitions::run());
    }

    protected function parseFields(array $fields)
    {
        if(count($fields) > 0)
        {
            foreach ($fields as $field)
            {
                $this->crud->addField($field);
            }
        }
    }
}
