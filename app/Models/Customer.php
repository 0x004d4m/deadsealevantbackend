<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'password',
        'access_token',
        'email_token',
        'email_code',
        'email_verified',
        'forget_token',
        'forget_code',
    ];
}
