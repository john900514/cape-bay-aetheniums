<?php

namespace App\Actions\Aetheniums\Library;

use Lorisleiva\Actions\Concerns\AsAction;

class ConvertLibrariesArrayToSelectDropdown
{
    use AsAction;

    public function handle(array $libraries)
    {
        $results = [];

        if(count($libraries) > 0)
        {
            $results = [
                'libraries' => [
                    'select' => [],
                    'routes' => []
                ],
            ];
            foreach ($libraries as $idx => $library)
            {
                $results['libraries']['select'][$library['id']] = $library['name'];
                $results['libraries']['routes'][$library['id']] = $library['listing_route'];

                if(array_key_exists('projects', $library))
                {
                    if(!array_key_exists('projects', $results))
                    {
                        $results['projects'] = [];
                    }

                    $results['projects'][$library['id']] = [
                        'select' => [],
                        'routes' => []
                    ];

                    foreach($library['projects'] as $idy => $project)
                    {
                        $results['projects'][$library['id']]['select'][$project['id']] = $project['name'];
                        $results['projects'][$library['id']]['routes'][$project['id']] = $project['listing_route'];
                    }
                }
                elseif(array_key_exists('projects_with_topics', $library))
                {
                    if(!array_key_exists('projects', $results))
                    {
                        $results['projects'] = [];
                    }

                    $results['projects'][$library['id']] = [
                        'select' => [],
                        'routes' => []
                    ];

                    foreach($library['projects_with_topics'] as $idy => $project)
                    {
                        $results['projects'][$library['id']]['select'][$project['id']] = $project['name'];
                        $results['projects'][$library['id']]['routes'][$project['id']] = $project['listing_route'];

                        if(!array_key_exists('topics', $results))
                        {
                            $results['topics'] = [];
                        }

                        $results['topics'][$project['id']] = [
                            'select' => [],
                            'routes' => []
                        ];

                        foreach($project['topics'] as $idz => $topic)
                        {
                            $results['topics'][$project['id']]['select'][$topic['id']] = $topic['name'];
                            $results['topics'][$project['id']]['routes'][$topic['id']] = $topic['listing_route'];
                        }
                    }
                }
                elseif(array_key_exists('projects_with_topics_and_articles', $library))
                {
                    if(!array_key_exists('projects', $results))
                    {
                        $results['projects'] = [];
                    }

                    $results['projects'][$library['id']] = [
                        'select' => [],
                        'routes' => []
                    ];

                    foreach($library['projects_with_topics_and_articles'] as $idy => $project)
                    {
                        $results['projects'][$library['id']]['select'][$project['id']] = $project['name'];
                        $results['projects'][$library['id']]['routes'][$project['id']] = $project['listing_route'];

                        if(!array_key_exists('topics', $results))
                        {
                            $results['topics'] = [];
                        }

                        $results['topics'][$project['id']] = [
                            'select' => [],
                            'routes' => []
                        ];

                        foreach($project['topics_with_articles'] as $idz => $topic)
                        {
                            $results['topics'][$project['id']]['select'][$topic['id']] = $topic['name'];
                            $results['topics'][$project['id']]['routes'][$topic['id']] = $topic['listing_route'];

                            if(!array_key_exists('articles', $results))
                            {
                                $results['articles'] = [];
                            }

                            $results['articles'][$topic['id']] = [
                                'select' => [],
                                'routes' => []
                            ];

                            foreach($topic['articles'] as $ida => $article)
                            {
                                $results['articles'][$topic['id']]['select'][$article['id']] = $topic['name'];
                                $results['articles'][$topic['id']]['routes'][$article['id']] = $topic['listing_route'];
                            }
                        }
                    }
                }

            }
        }

        return $results;
    }

    private function getProjectsObject(array $library)
    {

        $results = [
            'select' => [],
            'routes' => []
        ];

        return $results;
    }
}
