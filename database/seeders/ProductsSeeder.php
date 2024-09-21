<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
        array_shift($data);
        foreach ($data as $row) {
            $productId = DB::table('products')->insertGetId([
                'category_id' => $row[4],
                'title' => '{"en":"' . addslashes($row[1]) . '"}',
                'description' => '{"en":"' . addslashes($row[2]) . '"}',
                'image' => $this->sanitizeExcelFormula($row[6]),
                'price' => $row[3],
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!empty($row[7])) {
                $images = explode(',', $this->sanitizeExcelFormula($row[7]));
                foreach ($images as $image) {
                    DB::table('product_images')->insert([
                        'product_id' => $productId,
                        'image' => trim($image),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $productFolder = public_path('product_images/' . $productId);
            if (File::exists($productFolder)) {
                $imageFiles = File::files($productFolder);
                foreach ($imageFiles as $file) {
                    if ($file->getFilename() != 'Thumbs.db') {
                        DB::table('product_images')->insert([
                            'product_id' => $productId,
                            'image' => url('product_images/' . $productId . '/' . $file->getFilename()),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
    private function sanitizeExcelFormula($value)
    {
        // Handle formula-like strings, just return the value after =IFERROR or similar
        if (strpos($value, '=') === 0) {
            return preg_replace('/^=.*?\"(.+?)\"/', '$1', $value); // Extract string inside the formula
        }
        return $value;
    }
}
