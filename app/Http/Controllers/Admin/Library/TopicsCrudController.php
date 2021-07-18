<?php

namespace App\Http\Controllers\Admin\Library;

use Backpack\ReviseOperation\ReviseOperation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\StandardRequest as TopicsRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TopicsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TopicsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\LibraryOfBabble\Topic::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin/topics');
        CRUD::setEntityNameStrings('topics', 'topics');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->type('text')->label('Topic');
        CRUD::column('project.name')->type('text')->label('Project');
        CRUD::column('library_name')->type('closure')->label('Library')
            ->function(function($entry) {
                return $entry->project->library->name;
            });
        CRUD::column('active')->type('boolean');

        $this->crud->addButtonFromModelFunction('line', 'open_listing_route', 'open_listing_route', 'beginning');

        /**
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
        CRUD::setValidation(TopicsRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
        CRUD::field('name')->type('text')->label('name')->wrapper(['class' => 'col-md-6']);
        CRUD::field('icon')->type('text')->wrapper(['class' => 'col-md-6']);
        CRUD::field('misc[library_id]')->label('Library')->type('topics.select2_topic_mgnt_library')->wrapper(['class' => 'col-md-6']);
        CRUD::field('project_id')->label('Project')->type('topics.select2_topic_mgnt_project')->wrapper(['class' => 'col-md-6']);
        CRUD::field('desc')->type('text')->wrapper(['class' => 'col-md-12']);
        CRUD::field('listing_route')->type('topics.text_topic_mgnt_listing_route')->wrapper(['class' => 'col-md-6']);
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
        CRUD::field('misc[library_id]')->label('Library')->type('topics.select2_topic_mgnt_library')->wrapper(['class' => 'col-md-6'])
            ->value($misc['library_id']);

        CRUD::field('project_id')->label('Project')->type('topics.select2_topic_mgnt_project')->wrapper(['class' => 'col-md-6'])
            ->value($entry->project_id);

        CRUD::field('desc')->type('text')->wrapper(['class' => 'col-md-12']);
        CRUD::field('listing_route')->type('topics.text_topic_mgnt_listing_route')->wrapper(['class' => 'col-md-6'])
            ->value($entry->listing_route);

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
