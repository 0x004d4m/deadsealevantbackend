<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        $this->crud->removeColumn('description');
        $this->crud->addColumn('category_id', [
            'label' => "Category",
            'type' => "select",
            'name' => 'category_id',
            'entity' => 'category',
            'attribute' => "name",
            'model' => 'App\Models\Category'
        ]);
        $this->crud->setColumnDetails('category_id', [
            'label' => "Category",
            'type' => "select",
            'name' => 'category_id',
            'entity' => 'category',
            'attribute' => "name",
            'model' => 'App\Models\Category'
        ]);
        $this->crud->setColumnDetails('image', [
            'name'   => 'image',
            'type'   => 'image',
            'label'  => 'Image',
            'function' => function ($entry) {
                if (strpos($entry->image, 'http') === 0) {
                    return $entry->image;
                } else {
                    return url('storage/' . $entry->image);
                }
            },
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        $this->crud->addField([
            'label' => "Category",
            'type' => "select",
            'name' => 'category_id',
            'entity' => 'category',
            'attribute' => "name",
            'model' => 'App\Models\Category'
        ]);
        $this->crud->field([
            'name'   => 'image',
            'type'   => 'upload',
            'label'  => 'Image',
            'withFiles' => true
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
        $this->crud->addColumn('description');
    }
}
