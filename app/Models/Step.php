<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;

class Step extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    protected $table = 'steps';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'title',
        'description',
    ];
    protected $translatable = [
        'title',
        'description',
    ];
}
