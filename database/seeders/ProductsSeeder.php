<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
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

            Log::debug($productId);

            // Create folders for storing product images
            $productFolder = public_path('product_images/' . $productId);
            $excelProductFolder = public_path('excel_product_images/' . $productId);

            if (!File::exists($productFolder)) {
                File::makeDirectory($productFolder, 0755, true);
            }
            if (!File::exists($excelProductFolder)) {
                File::makeDirectory($excelProductFolder, 0755, true);
            }

            // Download and store main image from Excel URL in excel_product_images/{productId}
            $mainImageUrl = $this->sanitizeExcelFormula($row[6]); // Assuming main image URL from Excel
            $mainImageFile = $this->downloadImage($mainImageUrl, $excelProductFolder, 'main_image'); // Save as main_image.*

            // Check if main image exists in the product folder
            $mainImageFromFolder = $this->getMainImageFromFolder($productFolder);

            // If the main image exists in the folder, use it. Otherwise, use the downloaded image from Excel.
            if ($mainImageFromFolder) {
                // Main image exists in the folder
                $mainImageFile = 'product_images/' . $productId . '/' . $mainImageFromFolder;
            } else {
                // No main image in the folder, so use the downloaded one from Excel
                if ($mainImageFile) {
                    $mainImageFile = 'excel_product_images/' . $productId . '/' . $mainImageFile;
                }
            }

            Log::debug('$mainImageFile' . $mainImageFile);

            // Update the product with the correct main image path (from either folder)
            if ($mainImageFile) {
                DB::table('products')->where('id', $productId)->update([
                    'image' => url($mainImageFile),
                ]);
            }

            // Download and store additional images from Excel URLs in excel_product_images/{productId}
            $additionalImagesUrls = !empty($row[7]) ? explode(',', $this->sanitizeExcelFormula($row[7])) : [];
            // foreach ($additionalImagesUrls as $imageUrl) {
            //     $this->downloadImage(trim($imageUrl), $excelProductFolder); // Download all additional images from Excel
            // }

            // Check if additional images exist in the product folder
            $additionalImagesFromFolder = $this->getAdditionalImagesFromFolder($productFolder);

            // If additional images exist in the product folder, use them. Otherwise, use images from the Excel folder.
            if (!empty($additionalImagesFromFolder)) {
                foreach ($additionalImagesFromFolder as $file) {
                    DB::table('product_images')->insert([
                        'product_id' => $productId,
                        'image' => url('product_images/' . $productId . '/' . $file),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                foreach ($additionalImagesUrls as $imageUrl) {
                    $imageFile = basename(parse_url(trim($imageUrl), PHP_URL_PATH));
                    DB::table('product_images')->insert([
                        'product_id' => $productId,
                        'image' => url('excel_product_images/' . $productId . '/' . $imageFile),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Get the main image from the product folder.
     */
    private function getMainImageFromFolder($folder)
    {
        $mainImageFiles = File::glob($folder . '/main_image.*'); // Find any main_image.*
        return count($mainImageFiles) > 0 ? basename($mainImageFiles[0]) : null; // Return the first main image file found
    }

    /**
     * Get all additional images (non-main images) from the product folder.
     */
    private function getAdditionalImagesFromFolder($folder)
    {
        $imageFiles = File::files($folder);
        $additionalImages = [];
        foreach ($imageFiles as $file) {
            if (!str_starts_with($file->getFilename(), 'main_image') && $file->getFilename() != 'Thumbs.db') {
                $additionalImages[] = $file->getFilename();
            }
        }
        return $additionalImages;
    }

    /**
     * Download image from URL and save it to the specified folder.
     */
    private function downloadImage($url, $folder, $fileName = null)
    {
        try {
            // Get the file name from the URL if not provided
            if (!$fileName) {
                $fileName = basename(parse_url($url, PHP_URL_PATH));
            } else {
                // Ensure the file has the correct extension
                $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                $fileName .= '.' . $extension;
            }

            // Download the image
            $response = Http::get($url);

            // Check if the download is successful
            if ($response->successful()) {
                // Save the file in the folder
                $filePath = $folder . '/' . $fileName;
                File::put($filePath, $response->body());
                return $fileName; // Return the file name to be saved in the database
            }
        } catch (\Exception $e) {
            // Log error or handle exception (e.g., skip the image)
            Log::error("Failed to download image from URL: $url, Error: " . $e->getMessage());
            return null;
        }

        return null;
    }

    /**
     * Sanitize formula-like Excel strings.
     */
    private function sanitizeExcelFormula($value)
    {
        // Handle formula-like strings, just return the value after =IFERROR or similar
        if (strpos($value, '=') === 0) {
            return preg_replace('/^=.*?\"(.+?)\"/', '$1', $value); // Extract string inside the formula
        }
        return $value;
    }
}
