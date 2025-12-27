<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'admin_activity_logs';

    protected $fillable = [
        'admin_id',
        'action',
        'data',
        'created_at',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
