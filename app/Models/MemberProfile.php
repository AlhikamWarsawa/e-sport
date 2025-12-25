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
        'qr_code_path',
        'payment_proof',
        'status',
        'approved_at',
        'rejected_reason',
    ];

    protected $casts = [
        'birth_date'  => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'member_id', 'id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo
            ? asset('images/profile/' . $this->photo)
            : null;
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof
            ? asset('images/proof/' . $this->payment_proof)
            : null;
    }

    public function getQrCodeUrlAttribute(): ?string
    {
        return $this->qr_code_path
            ? asset('images/qr/' . $this->qr_code_path)
            : null;
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
