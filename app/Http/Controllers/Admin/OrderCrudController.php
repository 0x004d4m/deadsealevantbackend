<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Log;

class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb();
        $this->crud->removeColumns([
            'payment_id',
            'transaction_reference',
            'response_message',
        ]);
        $this->crud->addColumn('guest_id', [
            'label' => "Guest",
            'type' => "select",
            'name' => 'guest_id',
            'entity' => 'guest',
            'attribute' => "first_name",
            'model' => 'App\Models\Guest'
        ]);
        $this->crud->setColumnDetails('guest_id', [
            'label' => "Guest",
            'type' => "select",
            'name' => 'guest_id',
            'entity' => 'guest',
            'attribute' => "first_name",
            'model' => 'App\Models\Guest'
        ]);
        $this->crud->addColumn('customer_id', [
            'label' => "Customer",
            'type' => "select",
            'name' => 'customer_id',
            'entity' => 'customer',
            'attribute' => "username",
            'model' => 'App\Models\Customer'
        ]);
        $this->crud->setColumnDetails('customer_id', [
            'label' => "Customer",
            'type' => "select",
            'name' => 'customer_id',
            'entity' => 'customer',
            'attribute' => "username",
            'model' => 'App\Models\Customer'
        ]);
        $this->crud->addColumn('customer_address_id', [
            'label' => "Customer Address",
            'type' => "select",
            'name' => 'customer_address_id',
            'entity' => 'customerAddress',
            'attribute' => "address",
            'model' => 'App\Models\CustomerAddress'
        ]);
        $this->crud->setColumnDetails('customer_address_id', [
            'label' => "Customer Address",
            'type' => "select",
            'name' => 'customer_address_id',
            'entity' => 'customerAddress',
            'attribute' => "address",
            'model' => 'App\Models\CustomerAddress'
        ]);
        $this->crud->addColumn('order_status_id', [
            'label' => "OrderStatus",
            'type' => "select",
            'name' => 'order_status_id',
            'entity' => 'orderStatus',
            'attribute' => "name",
            'model' => 'App\Models\OrderStatus'
        ]);
        $this->crud->setColumnDetails('order_status_id', [
            'label' => "OrderStatus",
            'type' => "select",
            'name' => 'order_status_id',
            'entity' => 'orderStatus',
            'attribute' => "name",
            'model' => 'App\Models\OrderStatus'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->removeAllFields();
        $currentStatus = $this->crud->getCurrentEntry()->id;
        Log::debug($currentStatus);
        $statusQuery = \App\Models\OrderStatus::query();

        if ($currentStatus == 2) {
            $statusQuery->whereIn('id', [3, 4, $currentStatus]);
        } else {
            $statusQuery->where('id', '=', $currentStatus);
        }

        CRUD::addField([
            'name' => 'order_status_id',
            'label' => 'Order Status',
            'type' => 'select',
            'entity' => 'orderStatus',
            'attribute' => 'name',
            'model' => \App\Models\OrderStatus::class,
            'options'   => (function () use ($statusQuery) {
                return $statusQuery->get();
            }),
        ]);
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
