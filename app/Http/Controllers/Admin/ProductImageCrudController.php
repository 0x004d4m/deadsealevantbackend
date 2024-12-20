<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductImageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductImageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductImageCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ProductImage::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product-image');
        CRUD::setEntityNameStrings('product image', 'product images');
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

        $this->crud->addColumn('product_id', [
            'label' => "Product",
            'type' => "select",
            'name' => 'product_id',
            'entity' => 'product',
            'attribute' => "title",
            'model' => 'App\Models\Product'
        ]);
        $this->crud->setColumnDetails('product_id', [
            'label' => "Product",
            'type' => "select",
            'name' => 'product_id',
            'entity' => 'product',
            'attribute' => "title",
            'model' => 'App\Models\Product'
        ]);
        $this->crud->setColumnDetails('image', [
            'name'   => 'image',
            'type'   => 'image',
            'label'  => 'Image',
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
        CRUD::setValidation(ProductImageRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        $this->crud->addField([
            'label' => "Product",
            'type' => "select",
            'name' => 'product_id',
            'entity' => 'product',
            'attribute' => "title",
            'model' => 'App\Models\Product'
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
    }
}
