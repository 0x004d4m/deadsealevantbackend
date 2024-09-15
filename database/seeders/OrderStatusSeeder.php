<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_statuses')->insert([
            ['id' => 1, 'name' => '{"en":"In Progress (Not Paid)","ar":"طلب جديد (غير مدفوع)"}', 'color' => '&#x1F534;'],
            ['id' => 2, 'name' => '{"en":"In Progress (Paid)","ar":"طلب جديد (مدفوع)"}', 'color' => '&#x1F534;'],
            ['id' => 3, 'name' => '{"en":"Cancelled","ar":"طلب ملغي"}', 'color' => '&#x1F7E2;'],
            ['id' => 4, 'name' => '{"en":"Shipped","ar":"تم شحن الطلب"}', 'color' => '&#x1F7E1;'],
        ]);
    }
}
