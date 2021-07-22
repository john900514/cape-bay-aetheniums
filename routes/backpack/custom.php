<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Library',
], function () { // custom admin routes
    Route::get('libraries/cnb', 'LibraryAccessController@cnb_library_access');
    Route::get('libraries/trufit', 'LibraryAccessController@trufit_library_access');
    Route::get('libraries/{others}', 'LibraryAccessController@generic_library_access');

    Route::get('projects/cnb/{project}', 'LibraryAccessController@cnb_project_access');
    Route::get('projects/cnb/{project}/topics', 'LibraryAccessController@cnb_topic_access');
    Route::get('projects/cnb/{project}/articles/{article}', 'LibraryAccessController@view_specific_article');


    Route::get('projects/trufit/{project}', 'LibraryAccessController@trufit_project_access');
    Route::get('projects/trufit/{project}/topics', 'LibraryAccessController@trufit_topic_access');
    Route::get('projects/trufit/{project}/articles/{article}', 'LibraryAccessController@view_specific_article');
    // if any specific libraries are gonna be hardcoded, they start right below this line

    // if any specific libraries are gonna be hardcoded, they need to go above this line
    Route::get('projects/{library}/{project}', 'LibraryAccessController@generic_project_access');
    Route::get('projects/{library}/{project}/topics', 'LibraryAccessController@generic_topic_access');
    Route::get('projects/{library}/{project}/articles/{article}', 'LibraryAccessController@view_article');
});

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('dashboard', 'DashboardController@index');
    Route::crud('admin/libraries', 'Library\LibrariesCrudController');
    Route::crud('admin/projects', 'Library\ProjectsCrudController');
    Route::crud('admin/topics', 'Library\TopicsCrudController');
    Route::crud('admin/articles', 'Library\ArticleCrudController');
}); // this should be the absolute last line of this file
