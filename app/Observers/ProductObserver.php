<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function saved(Product $product)
    {
        if (request()->hasFile('product_images')) {
            foreach (request()->file('product_images') as $file) {
                $path = $file->store('products', 'public');

                // Create a new product image entry in the database
                $product->productImages()->create([
                    'image' => $path,
                ]);
            }
        }
    }
}
