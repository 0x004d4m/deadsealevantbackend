<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ["id" => 1, "name" => '{"en":"KSA","ar":"المملكة العربية السعودية"}'],
            ["id" => 2, "name" => '{"en":"Jordan","ar":"الاردن"}'],
            ["id" => 3, "name" => '{"en":"USA","ar":"الولايات المتحدة الامريكية"}'],
        ]);
    }
}
