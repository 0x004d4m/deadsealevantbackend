<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\ProductImage;

class UpdateProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:product-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update product images if a folder matching the product ID exists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();
        $baseFolder = public_path('product_images2');

        foreach ($products as $product) {
            $productFolder = $baseFolder . '/' . $product->id;

            if (File::exists($productFolder)) {
                // Handle main image
                $mainImage = $this->getMainImageFromFolder($productFolder);
                if ($mainImage) {
                    // Update the product's main image in the database
                    $product->update(['image' => $mainImage]);
                    $this->info('Updated main image for product ID: ' . $product->id);
                }

                // Handle additional images
                $additionalImages = $this->getAdditionalImagesFromFolder($productFolder);
                if (!empty($additionalImages)) {
                    // Delete existing additional images in the database
                    $this->deleteExistingProductImages($product);

                    // Insert new additional images into the database
                    foreach ($additionalImages as $image) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image' => $image,
                        ]);
                    }

                    $this->info('Updated additional images for product ID: ' . $product->id);
                }
            } else {
                $this->info('No folder found for product ID: ' . $product->id);
            }
        }

        $this->info('Product image update complete.');
    }

    /**
     * Delete existing additional images for the product in the product_images table.
     */
    private function deleteExistingProductImages(Product $product)
    {
        // Delete all existing additional images from the product_images table
        ProductImage::where('product_id', $product->id)->delete();
    }

    /**
     * Get the main image from the folder.
     * Looks for main_image.* (any extension) in the specified folder.
     */
    private function getMainImageFromFolder($folder)
    {
        $mainImageFiles = File::glob($folder . '/main_image.*'); // Find any main_image.*
        return count($mainImageFiles) > 0 ? str_replace(public_path(), '', $mainImageFiles[0]) : null; // Return the relative path to the image
    }

    /**
     * Get all additional images (non-main images) from the specified folder.
     */
    private function getAdditionalImagesFromFolder($folder)
    {
        $imageFiles = File::files($folder);
        $additionalImages = [];

        foreach ($imageFiles as $file) {
            if (!str_starts_with($file->getFilename(), 'main_image') && $file->getFilename() != 'Thumbs.db') {
                $relativePath = str_replace(public_path(), '', $folder . '/' . $file->getFilename());
                $additionalImages[] = $relativePath;
            }
        }
        return $additionalImages;
    }
}
