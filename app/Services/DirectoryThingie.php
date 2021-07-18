<?php

namespace App\Services;

use App\Actions\Aetheniums\Library\ConvertLibrariesArrayToSelectDropdown;
use App\Actions\Aetheniums\Library\GetAllLibraries;
use App\Models\LibraryOfBabble\Library;

class DirectoryThingie
{
    protected $library_model;
    protected $libraries;

    public function __construct(Library $library)
    {
        $this->library_model = $library;
    }

    public function initAvailableLibraries(bool $include_projects = false, bool $include_topics = false, bool $include_articles = false)
    {
        // @todo - add params
        $this->libraries = GetAllLibraries::run($include_projects, $include_topics, $include_articles);

        return $this;
    }

    public function getAllLibrariesInArray()
    {
        return $this->libraries;
    }

    public function getAllLibrariesAsDropDown()
    {
        return ConvertLibrariesArrayToSelectDropdown::run($this->getAllLibrariesInArray());
    }
}
