<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('products.xlsx');
        $data = Excel::toArray(null, $filePath)[0];
        array_shift($data); // Remove headers

        foreach ($data as $row) {
            // Insert the product without an image initially
            $productId = DB::table('products')->insertGetId([
                'category_id' => $row[4],
                'title' => '{"en":"' . addslashes($row[1]) . '"}',
                'description' => '{"en":"' . addslashes($row[2]) . '"}',
                'image' => null, // Set to null initially, will update later
                'price' => $row[3],
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create folders for storing product images if they don't exist
            $productFolder = public_path('product_images/' . $productId);
            $excelProductFolder = public_path('excel_product_images/' . $productId);

            // Ensure folders exist
            if (!File::exists($productFolder)) {
                File::makeDirectory($productFolder, 0755, true);
            }
            if (!File::exists($excelProductFolder)) {
                File::makeDirectory($excelProductFolder, 0755, true);
            }

            // Main Image Handling: Check product folder first, then fallback to Excel folder
            $mainImageFromFolder = $this->getMainImageFromFolder($productFolder);
            if (!$mainImageFromFolder) {
                $mainImageFromFolder = $this->getMainImageFromFolder($excelProductFolder); // Fallback to Excel folder
            }

            if ($mainImageFromFolder) {
                // Update the product with the main image (either from product or excel folder)
                DB::table('products')->where('id', $productId)->update([
                    'image' => url($mainImageFromFolder),
                ]);
            }

            // Additional Images Handling: Check product folder first, then fallback to Excel folder
            $additionalImagesFromFolder = $this->getAdditionalImagesFromFolder($productFolder, $productId);
            if (empty($additionalImagesFromFolder)) {
                $additionalImagesFromFolder = $this->getAdditionalImagesFromFolder($excelProductFolder, $productId); // Fallback to Excel folder
            }

            // Insert additional images into the product_images table
            foreach ($additionalImagesFromFolder as $file) {
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'image' => url($file),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
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
    private function getAdditionalImagesFromFolder($folder, $productId)
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
