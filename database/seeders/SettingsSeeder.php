<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'fansclub_name' => 'Fansclub Esport',
                'fansclub_description' => 'Official fansclub',
                'logo_image' => 'logo.png',
                'banner_image' => 'banner.png'
                ,
            ]
        );
    }
}
