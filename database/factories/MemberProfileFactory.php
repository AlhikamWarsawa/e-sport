<?php

namespace Database\Factories;

use App\Models\MemberProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MemberProfileFactory extends Factory
{
    protected $model = MemberProfile::class;

    public function definition(): array
    {
        return [
            'full_name'     => $this->faker->name,
            'email'         => $this->faker->unique()->safeEmail,
            'phone'         => '08' . $this->faker->numberBetween(100000000, 999999999),
            'birth_date'    => $this->faker->date(),
            'address'       => $this->faker->address,
            'city'          => $this->faker->city,
            'status'        => 'pending',
            'membership_id' => 'REG-' . Str::upper(Str::random(6)),
            'qr_code_path'  => null,
            'photo'         => null,
            'payment_proof' => 'proof_' . Str::random(10) . '.jpg',
        ];
    }

    public function approved(): self
    {
        return $this->state(fn () => [
            'status'        => 'approved',
            'membership_id' => 'FANS-' . now()->year . '-' . $this->faker->unique()->numberBetween(1000, 9999),
        ]);
    }

    public function rejected(): self
    {
        return $this->state(fn () => [
            'status' => 'rejected',
        ]);
    }
}
