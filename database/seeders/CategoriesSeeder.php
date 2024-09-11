<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [ "id" => 1, "name" => '{"en":"Body Care","ar":"العناية بالجسم"}' ],
            [ "id" => 2, "name" => '{"en":"Facial Care","ar":"العناية بالوجه"}' ],
            [ "id" => 3, "name" => '{"en":"Hair Care","ar":"العناية بالشعر"}' ],
            [ "id" => 4, "name" => '{"en":"Mixed Uses","ar":"متعدد الاستخدامات"}' ],
        ]);
    }
}
