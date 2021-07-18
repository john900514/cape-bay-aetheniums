<?php

namespace App\Services;

use App\Models\Content\Page;

class PageContentHelperDoodad
{
    protected $pages_model;

    public function __construct(Page $pages)
    {
        $this->pages_model = $pages;
    }

    public function getAllTemplates()
    {
        $results = [];

        $templates = $this->pages_model->select('template')
            ->groupBy('template')
            ->orderBy('template', 'ASC')
            ->get();

        if(count($templates) > 0)
        {
            foreach($templates as $template)
            {
                $results[] = $template->template;
            }
        }

        return $results;
    }

    public function getTemplatesDesignedForArticles()
    {
        $results = [];

        $templates = $this->pages_model->select('template')
            ->where('template', 'LIKE', '%_article%')
            ->groupBy('template')
            ->orderBy('template', 'ASC')
            ->get();

        if(count($templates) > 0)
        {
            foreach($templates as $template)
            {
                $results[] = $template->template;
            }
        }

        return $results;
    }

    public function getPagesWithTheseTemplates(array $templates)
    {
        $results = [];

        $pages = $this->pages_model->whereIn('template', $templates)->get();

        if(count($pages) > 0)
        {
            $results = $pages->toArray();
        }

        return $results;
    }

    public function getAllPagesAsDropDown(array $pages)
    {
        $results = [];

        if(count($pages) > 0)
        {
            foreach($pages as $idx => $page)
            {
                $results[$page['slug']] = $page['name'];
            }
        }

        return $results;
    }
}
