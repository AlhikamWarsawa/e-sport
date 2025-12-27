<?php

namespace Tests\Support;

use App\Models\User;
use App\Models\News;
use App\Models\Merchandise;
use App\Models\MemberProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * Helper untuk bikin user admin/member + data minimal.
 * Sesuaikan field role / status sesuai skema project kamu.
 */
trait CreatesTestData
{
    protected function createAdminUser(array $overrides = []): User
    {
        // ADJUST HERE: kalau role pakai enum/boolean lain, ubah.
        return User::factory()->create(array_merge([
            'name' => 'Admin Test',
            'email' => 'admin'.Str::random(6).'@test.local',
            'password' => Hash::make('password'),
            'role' => 'admin', // <-- kalau kamu pakai is_admin, ganti
        ], $overrides));
    }

    protected function createMemberUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Member Test',
            'email' => 'member'.Str::random(6).'@test.local',
            'password' => Hash::make('password'),
            'role' => 'member', // <-- kalau gak ada role member, hapus saja
        ], $overrides));
    }

    /**
     * Login admin via guard admin.
     */
    protected function actingAsAdmin(User $admin): void
    {
        $this->actingAs($admin, 'admin');
    }

    /**
     * Login member via guard member.
     */
    protected function actingAsMember(User $member): void
    {
        $this->actingAs($member, 'member');
    }

    /**
     * Create published news with slug for frontend show route.
     * ADJUST HERE: Model + columns.
     */
    protected function createPublishedNews(array $overrides = [])
    {
        $admin = $overrides['created_by'] ?? $this->createAdminUser();

        return News::factory()->create(array_merge([
            'title' => 'Test News '.Str::random(6),
            'slug' => 'test-news-'.Str::random(8),
            'summary' => 'Short summary '.Str::random(8),
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ], $overrides));
    }

    /**
     * Create merchandise with slug for frontend show route.
     * ADJUST HERE: Model + columns.
     */
    protected function createMerchandise(array $overrides = [])
    {
        $admin = $overrides['created_by'] ?? $this->createAdminUser();

        return Merchandise::factory()->create(array_merge([
            'name' => 'Test Merch '.Str::random(6),
            'slug' => 'test-merch-'.Str::random(8),
            'created_by' => $admin->id,
        ], $overrides));
    }

    /**
     * Create member profile pending/approved/rejected.
     * ADJUST HERE: Model + columns names.
     */
    protected function createMemberProfile(array $overrides = [])
    {
        return MemberProfile::factory()->create($overrides);
    }

    /**
     * Create approved member with linked user account for member guard access.
     */
    protected function createApprovedMemberUser(array $profileOverrides = []): User
    {
        $profile = MemberProfile::factory()->approved()->create(array_merge([
            'payment_proof' => 'proof_'.Str::random(8).'.jpg',
        ], $profileOverrides));

        return $this->createMemberUser([
            'member_id' => $profile->id,
            'status' => 'active',
        ]);
    }
}
