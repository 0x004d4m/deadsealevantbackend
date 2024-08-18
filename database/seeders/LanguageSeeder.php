<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            ['id' => 1, 'name' => "English", 'flag' => "", 'abbr' => "en", 'script' => "", 'native' => "English", 'active' => 1, 'default' => 1,],
            ['id' => 2, 'name' => "Arabic", 'flag' => "", 'abbr' => "ar", 'script' => "", 'native' => "العربية", 'active' => 1, 'default' => 0,],
        ]);
    }
}
