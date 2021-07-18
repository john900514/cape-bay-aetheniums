<?php

namespace App\Actions\Aetheniums\Content\Templates;

use Lorisleiva\Actions\Concerns\AsAction;

class GetTwilioArticleSchema
{
    use AsAction;

    public function handle(array $extras)
    {
        $results = [];

        $results['preface'] = $extras['preface']
            ?? 'This is a preface paragraph. This is a preface paragraph. This is a preface paragraph. This is a preface paragraph. This is a preface paragraph. This is a preface paragraph.';

        $results['sections'] = [];

        if(array_key_exists('sections', $extras))
        {
            $sections = json_decode($extras['sections'], true);

            foreach ($sections as $idx => $section)
            {
                $next_section = [
                    'title' => '',
                    'subsections'=> []
                ];

                if(array_key_exists('title', $section))
                {
                    $next_section['title'] = $section['title'];
                }

                if(array_key_exists('subsections', $section) && is_array($section['subsections']) && (count($section['subsections']) > 0))
                {
                    foreach ($section['subsections'] as $elem => $subsection)
                    {
                        switch($subsection['type'])
                        {
                            case 'textbody':
                                $next_section['subsections'][$elem] = [
                                    'type' => $subsection['type'],
                                    'content'=> $subsection['properties']['content']
                                ];
                                break;

                            case 'figure-image':
                                $next_section['subsections'][$elem] = [
                                    'type' => $subsection['type'],
                                    'src' => $subsection['properties']['src'],
                                    'alt' => $subsection['properties']['alt'],
                                    'height' => $subsection['properties']['height'],
                                    'width' => $subsection['properties']['width']
                                ];
                                break;

                            case 'card':
                                $next_section['subsections'][$elem] = [
                                    'type' => $subsection['type'],
                                    'content'=> $subsection['properties']['content'],
                                    //'text_centered' => $subsection['properties']['text_centered'] ?? 'text-center',
                                    //'color_text' => $subsection['properties']['color_text'] ?? '',
                                    'card_bg' => $subsection['properties']['bgColor'],
                                ];
                                break;
                        }
                    }

                }

                $results['sections'][$idx] = $next_section;
            }
        }

        return $results;
    }
}
