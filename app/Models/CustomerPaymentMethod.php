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
        'card_number_encrypted',
        'expiry_month',
        'expiry_year',
        'cvv',
    ];

    public function setCardNumberEncryptedAttribute($value)
    {
        $this->attributes['card_number_encrypted'] = Crypt::encryptString($value);
    }

    public function getCardNumberDecryptedAttribute()
    {
        return Crypt::decryptString($this->attributes['card_number_encrypted']);
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
