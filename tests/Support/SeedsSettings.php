<?php

namespace Tests\Support;

use App\Models\Setting;

trait SeedsSettings
{
    protected function seedSettings(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'fansclub_name' => 'Fansclub Esport',
                'fansclub_description' => 'Official fansclub',
                'logo_image' => 'settings/logo.png',
                'banner_image' => 'settings/banner.png',
            ]
        );
    }
}
