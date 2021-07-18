<?php

namespace App\Http\Controllers\Admin\Library;

use Backpack\ReviseOperation\ReviseOperation;
use AnchorCMS\Nautical\Models\RedfieldClient;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\StandardRequest as LibrariesRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LibrariesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LibrariesCrudController extends CrudController
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
        CRUD::setModel(\App\Models\LibraryOfBabble\Library::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin/libraries');
        CRUD::setEntityNameStrings('Library', 'Client Libraries');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        CRUD::column('name')->type('text')->label('Library');

        // @todo - this will need to be changed to a POST request to an Anchor endpoint to
        // get this data or an empty array
        $clients = RedfieldClient::whereActive(true)->get();
        CRUD::column('client')->type('closure')->label('Client')
            ->function(function($entry) use ($clients){
                $results = 'Cape & Bay';

                if(!is_null($entry->client_id))
                {
                    $client = $clients->where('id', '=', $entry->client_id)->first();

                    if(!is_null($client))
                    {
                        $results = $client->name;
                    }
                    else
                    {
                        $results = 'Unknown Client';
                    }
                }

                return $results;
            });

        CRUD::column('active')->type('boolean')->label('Active');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
        CRUD::setValidation(LibrariesRequest::class);

        CRUD::field('name')->type('text')->label('Library Name')->wrapper(['class' => 'col-md-6']);
        CRUD::field('icon')->type('text')->wrapper(['class' => 'col-md-6']);
        CRUD::field('misc[slug]')->label('Slug')->type('libraries.text_library_mgnt_slug')->wrapper(['class' => 'col-md-6']);
        CRUD::field('listing_route')->type('libraries.text_library_mgnt_listing_route')->wrapper(['class' => 'col-md-6']);

        $clients_array = RedfieldClient::getClientNameDropDown();
        CRUD::field('client_id')->type('select2_from_array')->label('Client')
            ->options($clients_array);

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

        CRUD::field('name')->type('text')->label('Library Name')->wrapper(['class' => 'col-md-6']);
        CRUD::field('icon')->type('text')->wrapper(['class' => 'col-md-6']);
        CRUD::field('misc[slug]')->label('Slug')->type('libraries.text_library_mgnt_slug')->wrapper(['class' => 'col-md-6'])
            ->value($misc['slug'] ?? '');

        CRUD::field('listing_route')->type('libraries.text_library_mgnt_listing_route')->wrapper(['class' => 'col-md-6']);

        $clients_array = RedfieldClient::getClientNameDropDown();
        CRUD::field('client_id')->type('select2_from_array')->label('Client')
            ->options($clients_array)->value($entry->client_id ?? '');

        CRUD::field('desc')->type('text')->wrapper(['class' => 'col-md-12']);
        CRUD::field('misc[priority]')->label('Priority')->type('number')->wrapper(['class' => 'col-md-6'])
            ->value($misc['priority'] ?? 0);
        CRUD::field('active')->type('boolean')->wrapper(['class' => 'col-md-12']);
    }

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
