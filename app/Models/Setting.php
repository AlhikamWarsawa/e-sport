<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    public $timestamps = false;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'fansclub_name',
        'fansclub_description',
        'logo_image',
        'banner_image',
    ];

    public static function current()
    {
        return self::where('id', 1)->first();
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo_image
            ? asset('images/settings/' . $this->logo_image)
            : null;
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner_image
            ? asset('images/settings/' . $this->banner_image)
            : null;
    }
}
