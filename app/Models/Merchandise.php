<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchandise extends Model
{
    use HasFactory;

    protected $table = 'merchandise';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function links()
    {
        return $this->hasMany(MerchandiseLink::class, 'merchandise_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('images/merch/' . $this->image)
            : '';
    }

}
