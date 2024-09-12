<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class CustomerPaymentMethod extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'card_number',
        'expiry_month',
        'expiry_year',
        'cvv',
        'cardholder_name',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function setCardNumberAttribute($value)
    {
        $this->attributes['card_number'] = Crypt::encryptString($value);
    }

    public function getCardNumberAttribute()
    {
        return Crypt::decryptString($this->attributes['card_number']);
    }

    public function setCvvAttribute($value)
    {
        $this->attributes['cvv'] = Crypt::encryptString($value);
    }

    public function getCvvAttribute()
    {
        return Crypt::decryptString($this->attributes['cvv']);
    }
}
