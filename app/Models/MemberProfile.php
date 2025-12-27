<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'qr_token',
        'qr_token_expires_at',
        'payment_proof',
        'status',
        'approved_at',
        'rejected_reason',
    ];

    protected $casts = [
        'birth_date'             => 'date',
        'approved_at'            => 'datetime',
        'qr_token_expires_at'    => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'member_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany(MembershipHistory::class, 'member_profile_id');
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

    public function getQrVerificationUrlAttribute(): ?string
    {
        return $this->qr_token
            ? route('member.verify', $this->qr_token)
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

    public function generateQrToken(): string
    {
        $token = Str::random(64);

        $this->update([
            'qr_token' => $token,
            'qr_token_expires_at' => null,
        ]);

        return $token;
    }

    public function isQrTokenValid(): bool
    {
        if (!$this->qr_token) {
            return false;
        }

        if ($this->qr_token_expires_at && now()->greaterThan($this->qr_token_expires_at)) {
            return false;
        }

        return true;
    }
}
