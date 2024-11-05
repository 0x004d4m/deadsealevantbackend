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

        CRUD::addColumn([
            'name' => 'customer_or_guest',
            'label' => 'Customer/Guest',
            'type' => 'custom_html',
            'value' => function ($entry) {
                if ($entry->customer_id) {
                    return
                        '<strong>Customer Name:</strong> ' . $entry->customer->first_name . " " . $entry->customer->last_name . '<br>' .
                        '<strong>Email:</strong> ' . $entry->customer->email . '<br>' .
                        '<strong>Country:</strong> ' . $entry->customerAddress->country->name . '<br>' .
                        '<strong>Phone Number:</strong> ' . $entry->customerAddress->phone_number . '<br>' .
                        '<strong>Address:</strong> ' . $entry->customerAddress->address . '<br>' .
                        '<strong>Address Details:</strong> ' . $entry->customerAddress->address_details . '<br>' .
                        '<strong>City:</strong> ' . $entry->customerAddress->city . '<br>' .
                        '<strong>State:</strong> ' . $entry->customerAddress->state . '<br>' .
                        '<strong>ZIP Code:</strong> ' . $entry->customerAddress->zip_code;
                } elseif ($entry->guest_id) {
                    return
                        '<strong>Guest Name:</strong> ' . $entry->guest->first_name . " " . $entry->guest->last_name . '<br>' .
                        '<strong>Country:</strong> ' . $entry->guest->country->name . '<br>' .
                        '<strong>Phone Number:</strong> ' . $entry->guest->phone_number . '<br>' .
                        '<strong>Address:</strong> ' . $entry->guest->address . '<br>' .
                        '<strong>Address Details:</strong> ' . $entry->guest->address_details . '<br>' .
                        '<strong>City:</strong> ' . $entry->guest->city . '<br>' .
                        '<strong>State:</strong> ' . $entry->guest->state . '<br>' .
                        '<strong>ZIP Code:</strong> ' . $entry->guest->zip_code;
                } else {
                    return 'Unknown';
                }
            }
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->removeAllFields();
        $currentStatus = $this->crud->getCurrentEntry()->id;
        $statusQuery = \App\Models\OrderStatus::query();

        if ($currentStatus == 1) {
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

        CRUD::addColumn([
            'name' => 'carts',
            'label' => 'Carts',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $html = '<ul>';
                foreach ($entry->carts as $cart) {
                    $productTitle = $cart->product ? $cart->product->title : 'N/A';
                    $quantity = $cart->quantity;
                    $price = $cart->product ? $cart->product->price : 'N/A';
                    $imageUrl = $cart->product ? $cart->product->image : null;

                    // Display image if available, with a fallback message if not
                    $imageTag = $imageUrl
                        ? "<img src='{$imageUrl}' alt='{$productTitle}' style='width: 50px; height: 50px; object-fit: cover; margin-right: 10px;'>"
                        : "<span>No image available</span>";

                    $html .= "<li>{$imageTag} <strong>Product:</strong> {$productTitle} - <strong>Quantity:</strong> {$quantity} - <strong>Price:</strong> {$price}</li>";
                }
                $html .= '</ul>';
                return $html;
            }
        ]);
    }
}
