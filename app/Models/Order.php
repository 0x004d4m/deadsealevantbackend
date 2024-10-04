<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guest_id',
        'customer_id',
        'customer_address_id',
        'order_status_id',
        'payment_id',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'transaction_reference',
        'response_message',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddress::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
