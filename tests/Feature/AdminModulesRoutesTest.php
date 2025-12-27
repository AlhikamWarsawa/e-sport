<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTestData;
use Tests\Support\SeedsSettings;

class AdminModulesRoutesTest extends TestCase
{
    use RefreshDatabase, CreatesTestData, SeedsSettings;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedSettings();
    }

    public function test_admin_settings_pages_ok(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        $this->get(route('admin.settings.index'))->assertOk();
        // PUT settings biasanya butuh payload valid; kita cukup pastikan route exists:
        $this->put(route('admin.settings.update'), [])->assertStatus(302); // likely validation redirect
    }

    public function test_admin_activity_logs_ok(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        $this->get(route('admin.activity_logs.index'))->assertOk();
    }

    public function test_admin_news_routes_ok(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        $this->get(route('admin.news.index'))->assertOk();
        $this->get(route('admin.news.create'))->assertOk();

        // store/update/destroy/toggle perlu data; minimal: pastikan redirect karena validasi
        $this->post(route('admin.news.store'), [])->assertStatus(302);
    }

    public function test_admin_applications_routes_ok(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        $profile = $this->createMemberProfile(['status' => 'pending']);

        $this->get(route('admin.applications.index'))->assertOk();

        // ADJUST HERE: routes pakai {id} -> pastikan model yang dipakai punya id
        $this->get(route('admin.applications.show', ['id' => $profile->id]))->assertOk();

        // approve/reject biasanya butuh logic + side effect; minimal ensure not 404
        $this->post(route('admin.applications.approve', ['id' => $profile->id]))->assertStatus(302);
        // create new pending again for reject, karena approve sudah mengubah status
        $profile2 = $this->createMemberProfile(['status' => 'pending']);
        $this->post(route('admin.applications.reject', ['id' => $profile2->id]))->assertStatus(302);
    }

    public function test_admin_merchandise_routes_ok(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        $this->get(route('admin.merchandise.index'))->assertOk();
        $this->get(route('admin.merchandise.create'))->assertOk();

        $this->post(route('admin.merchandise.store'), [])->assertStatus(302);

        $m = $this->createMerchandise();
        // admin routes pakai {id}
        $this->get(route('admin.merchandise.edit', ['id' => $m->id]))->assertOk();
        $this->put(route('admin.merchandise.update', ['id' => $m->id]), [])->assertStatus(302);
        $this->delete(route('admin.merchandise.destroy', ['id' => $m->id]))->assertStatus(302);
    }

    public function test_admin_members_routes_ok(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAsAdmin($admin);

        $this->get(route('admin.members.index'))->assertOk();

        $profile = $this->createMemberProfile([
            'status' => 'approved',
            'membership_id' => 'FANS-'.now()->format('Y').'-0001',
        ]);

        // route pakai {membership_id}
        $this->get(route('admin.members.show', ['membership_id' => $profile->membership_id]))->assertOk();
    }

    public function test_guest_cannot_access_any_admin_module(): void
    {
        $this->get(route('admin.news.index'))->assertRedirect();
        $this->get(route('admin.merchandise.index'))->assertRedirect();
        $this->get(route('admin.applications.index'))->assertRedirect();
        $this->get(route('admin.settings.index'))->assertRedirect();
        $this->get(route('admin.activity_logs.index'))->assertRedirect();
        $this->get(route('admin.members.index'))->assertRedirect();
    }
}
