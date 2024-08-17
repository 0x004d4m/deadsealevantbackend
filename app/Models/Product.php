<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    protected $table = 'products';
    protected $guarded = ['id'];
    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
    ];
    protected $translatable = [
        'title',
        'description',
    ];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
