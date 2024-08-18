<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::create([
            'name' => 'banner',
            'image' => 'images/banner.png',
        ]);
        Image::create([
            'name' => 'benefit1',
            'image' => 'images/benefit1.png',
        ]);
        Image::create([
            'name' => 'benefit2',
            'image' => 'images/benefit2.png',
        ]);
        Image::create([
            'name' => 'benefit3',
            'image' => 'images/benefit3.png',
        ]);
        Image::create([
            'name' => 'step',
            'image' => 'images/step.png',
        ]);
        Image::create([
            'name' => 'user profile',
            'image' => 'images/userprofile.png',
        ]);
        Image::create([
            'name' => 'contact us',
            'image' => 'images/contactus.png',
        ]);
        Image::create([
            'name' => 'no orders',
            'image' => 'images/noorders.png',
        ]);
        Image::create([
            'name' => 'checkout',
            'image' => 'images/checkout.png',
        ]);
        Image::create([
            'name' => 'no cards',
            'image' => 'images/nocards.png',
        ]);
        Image::create([
            'name' => 'order complete',
            'image' => 'images/ordercomplete.png',
        ]);
        Image::create([
            'name' => 'contact us success',
            'image' => 'images/contactussuccess.png',
        ]);
        Image::create([
            'name' => 'no shipping address',
            'image' => 'images/noshippingaddress.png',
        ]);
        Image::create([
            'name' => 'disadvantage1',
            'image' => 'images/banner.png',
        ]);
        Image::create([
            'name' => 'disadvantage2',
            'image' => 'images/banner.png',
        ]);
        Image::create([
            'name' => 'disadvantage3',
            'image' => 'images/banner.png',
        ]);
    }
}
