<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberProfile extends Model
{
    use HasFactory;

    protected $table = 'member_profiles';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'birth_date',
        'address',
        'city',
        'photo',
        'membership_id',
        'payment_proof',
        'status',
        'approved_at',
        'rejected_reason',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'member_id');
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('images/' . $this->photo)
            : null;
    }

    public function getPaymentProofUrlAttribute()
    {
        return $this->payment_proof
            ? asset('images/proof/' . $this->payment_proof)
            : null;
    }
}
