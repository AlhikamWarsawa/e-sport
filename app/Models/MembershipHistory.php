<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipHistory extends Model
{
    protected $fillable = [
        'member_profile_id',
        'type',
        'description',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = false;

    public function memberProfile()
    {
        return $this->belongsTo(MemberProfile::class);
    }
}
