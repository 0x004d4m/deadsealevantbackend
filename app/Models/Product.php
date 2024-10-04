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
    ];
    protected $translatable = [
        'title',
        'description',
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

    public function getImageAttribute($val)  {
        if (strpos($val, 'http') === 0) {
            return $val;
        }
        if (strpos($val, 'product_images')) {
            return $val;
        }
        return url('storage/' . $val);
    }

    public function setProductImagesAttribute($images)
    {
        $storedImages = [];

        if (is_array($images)) {
            foreach ($images as $image) {
                if (is_object($image) && $image->isValid()) {
                    $path = $image->store('products', 'public');
                    $storedImages[] = $path;
                }
            }
        }

        // Save image paths to the database (assuming it's stored as JSON)
        $this->attributes['product_images'] = json_encode($storedImages);
    }
}
