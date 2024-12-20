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

        // Add the carts column as the fifth column, displayed as a responsive table
        CRUD::addColumn([
            'name' => 'carts',
            'label' => 'Carts',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $html = '<table style="width: 100%; border-collapse: collapse; min-width: 600px;">';
                $html .= '
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; min-width: 80px;">Image</th>
                        <th style="border: 1px solid #ddd; padding: 8px; min-width: 100px;">Product</th>
                        <th style="border: 1px solid #ddd; padding: 8px; min-width: 80px;">Price</th>
                        <th style="border: 1px solid #ddd; padding: 8px; min-width: 80px;">Quantity</th>
                        <th style="border: 1px solid #ddd; padding: 8px; min-width: 80px;">Total</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($entry->carts as $cart) {
                    $productTitle = $cart->product ? $cart->product->title : 'N/A';
                    $quantity = $cart->quantity;
                    $price = $cart->product ? $cart->product->price : 0;
                    $total = $quantity * $price;
                    $imageUrl = $cart->product ? $cart->product->image : null;

                    // Create clickable image if available, with fallback text if not
                    $imageTag = $imageUrl
                        ? "<a href='{$imageUrl}' target='_blank'><img src='{$imageUrl}' alt='{$productTitle}' style='width: 50px; height: 50px; object-fit: cover;'></a>"
                        : "No image available";

                    $html .= "
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>{$imageTag}</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>{$productTitle}</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>{$price}$</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>{$quantity}</td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>{$total}$</td>
                    </tr>";
                }

                $html .= '</tbody></table>';
                return $html;
            }
        ])->beforeColumn('subtotal'); // Adjust this to place the carts column as needed
    }

}
