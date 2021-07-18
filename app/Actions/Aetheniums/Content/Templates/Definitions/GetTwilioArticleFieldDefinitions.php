<?php

namespace App\Actions\Aetheniums\Content\Templates\Definitions;

use Lorisleiva\Actions\Concerns\AsAction;

class GetTwilioArticleFieldDefinitions
{
    use AsAction;

    public function handle() : array
    {
        $results = [];

        $results['preface'] = [
            'label' => 'Preface Text',
            'name' => 'preface',
            'type' => 'easymde',
            'hint' => 'A < p > tag paragraph at the top of the article.',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Preface Text'
        ];

        $results['sections'] = [
            'label' => 'Sectional Content',
            'name' => 'sections',
            'type' => 'page-posts.field_group_twilio_style_pages_section_mgnt',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Sections'
        ];

        return $results;
    }
}
