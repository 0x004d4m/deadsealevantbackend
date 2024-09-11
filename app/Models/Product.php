<?php

namespace App\Models;

use App\Filters\ProductFilters;
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
        'category_id',
        'title',
        'description',
        'image',
        'price',
        'stock',
        'shipping_terms',
    ];
    protected $translatable = [
        'title',
        'description',
        'shipping_terms',
    ];

    public function scopeFilter($query, ProductFilters $filters)
    {
        return $filters->apply($query);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
