<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTestData;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase, CreatesTestData;

    public function test_admin_login_page_ok(): void
    {
        $this->get(route('admin.login'))->assertOk();
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_member_session_does_not_grant_admin_access(): void
    {
        $member = $this->createMemberUser();
        $this->actingAsMember($member);

        $this->get(route('admin.dashboard'))->assertRedirect();
    }
}
