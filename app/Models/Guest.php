<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'access_token',
        'first_name',
        'last_name',
        'country_id',
        'phone_number',
        'address',
        'address_details',
        'city',
        'state',
        'zip_code',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
