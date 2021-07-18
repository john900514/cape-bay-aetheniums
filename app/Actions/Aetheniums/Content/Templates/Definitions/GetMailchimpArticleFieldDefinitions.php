<?php

namespace App\Actions\Aetheniums\Content\Templates\Definitions;

use Lorisleiva\Actions\Concerns\AsAction;

class GetMailchimpArticleFieldDefinitions
{
    use AsAction;

    public function handle() : array
    {
        $results = [];

        $results['banner_img'] = [
            'label' => 'Banner Image',
            'name' => 'banner_img',
            'type' => 'image',
            'hint' => 'A banner image is required at the top of the template.',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Top Banner'
        ];

        $results['sections'] = [
            'label' => 'Sectional Content',
            'name' => 'sections',
            'type' => 'page-posts.field_group_mailchimp_style_pages_section_mgnt',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Sections'
        ];

        return $results;
    }
}
