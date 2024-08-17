<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use CrudTrait;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_images';
    protected $guarded = ['id'];
    protected $fillable = [
        'product_id',
        'image',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
