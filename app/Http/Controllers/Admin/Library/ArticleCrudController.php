<?php

namespace App\Http\Controllers\Admin\Library;

use Backpack\ReviseOperation\ReviseOperation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\StandardRequest as ArticleRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\LibraryOfBabble\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin/articles');
        CRUD::setEntityNameStrings('Article', 'Reference Articles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('name');
        CRUD::column('topic_id');
        CRUD::column('topic.project')->labe('Project');
        CRUD::column('active')->type('boolean');

        /**
         *
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ArticleRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
        CRUD::field('name')->type('text')->label('Slug')->wrapper(['class' => 'col-md-6']);
        CRUD::field('icon')->type('text')->wrapper(['class' => 'col-md-6']);

        CRUD::field('misc[library_id]')->label('Library')->type('select2_article_mgnt_library')->wrapper(['class' => 'col-md-6']);
        CRUD::field('misc[project_id]')->label('Project')->type('select2_article_mgnt_project')->wrapper(['class' => 'col-md-6']);
        CRUD::field('topic_id')->type('select2_article_mgnt_topic')->wrapper(['class' => 'col-md-6']);
        CRUD::field('listing_route')->type('text_article_mgnt_listing_route')->wrapper(['class' => 'col-md-6']);

        CRUD::field('misc[page_slug]')->type('select2_page_template')->label('Page/Post')
            ->wrapper(['class' => 'col-md-12'])
            ->hint('Assign a Post created in the Pages Creator CRUD using a template made for Articles.');
        CRUD::field('desc')->type('text')->wrapper(['class' => 'col-md-12']);
        CRUD::field('misc[priority]')->label('Priority')->type('number')->wrapper(['class' => 'col-md-6']);
        CRUD::field('active')->type('boolean')->wrapper(['class' => 'col-md-12']);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = $this->crud->getRequest()->request->all();
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $misc = $data['misc'];
        $this->data['entry']->misc = $misc;
        $this->data['entry']->save();

        return $this->crud->performSaveAction($item->getKey());
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $entry = $this->crud->getCurrentEntry();
        $misc = $entry->misc;

        CRUD::field('name')->type('text')->label('Topic')->wrapper(['class' => 'col-md-6']);
        CRUD::field('icon')->type('text')->wrapper(['class' => 'col-md-6']);

        CRUD::field('misc[library_id]')->label('Library')->type('select2_article_mgnt_library')->wrapper(['class' => 'col-md-6'])
            ->value($misc['library_id']);

        CRUD::field('misc[project_id]')->label('Project')->type('select2_article_mgnt_project')->wrapper(['class' => 'col-md-6'])
            ->value($misc['project_id']);

        CRUD::field('topic_id')->type('select2_article_mgnt_topic')->wrapper(['class' => 'col-md-6']);
        CRUD::field('listing_route')->type('text_article_mgnt_listing_route')->wrapper(['class' => 'col-md-6'])
            ->value($entry->listing_route);

        CRUD::field('misc[page_slug]')->type('select2_page_template')->label('Page/Post')
            ->value($misc['page_slug'])->wrapper(['class' => 'col-md-12'])
            ->hint('Assign a Post created in the Pages Creator CRUD using a template made for Articles.');

        CRUD::field('desc')->type('text')->wrapper(['class' => 'col-md-12']);

        CRUD::field('misc[priority]')->label('Priority')->type('number')->wrapper(['class' => 'col-md-6'])
            ->value($misc['priority']);

        CRUD::field('active')->type('boolean')->wrapper(['class' => 'col-md-12']);
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $data = $this->crud->getRequest()->request->all();
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $misc = $data['misc'];
        $this->data['entry']->misc = $misc;
        $this->data['entry']->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
