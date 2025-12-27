<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTestData;
use Tests\Support\SeedsSettings;

class MemberProtectedRoutesTest extends TestCase
{
    use RefreshDatabase, CreatesTestData, SeedsSettings;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedSettings();
    }

    public function test_guest_cannot_access_member_profile(): void
    {
        // biasanya redirect ke login member
        $this->get(route('member.profile'))->assertRedirect();
    }

    public function test_member_can_access_profile(): void
    {
        $member = $this->createApprovedMemberUser();
        $this->actingAsMember($member);

        $this->get(route('member.profile'))->assertOk();
    }

    public function test_member_logout_route_requires_member_session(): void
    {
        $this->post(route('member.logout'))->assertRedirect();
    }

    public function test_member_logout_works_when_logged_in(): void
    {
        $member = $this->createMemberUser();
        $this->actingAsMember($member);

        $this->post(route('member.logout'))->assertRedirect();
    }

    public function test_admin_session_does_not_grant_member_access(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        // admin login tidak boleh otomatis bisa buka /member/profile
        $this->get(route('member.profile'))->assertRedirect();
    }
}
