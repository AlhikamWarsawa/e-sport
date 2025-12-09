<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchandiseLink extends Model
{
    use HasFactory;

    protected $table = 'merchandise_links';

    protected $fillable = [
        'merchandise_id',
        'shop_name',
        'url',
    ];

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id');
    }
}
