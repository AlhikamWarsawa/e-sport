<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTestData;
use Tests\Support\SeedsSettings;

class FrontendRoutesTest extends TestCase
{
    use RefreshDatabase, CreatesTestData, SeedsSettings;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedSettings();
    }

    public function test_home_page_ok(): void
    {
        $this->get(route('home'))->assertOk();
    }

    public function test_news_index_ok(): void
    {
        $this->get(route('news.index'))->assertOk();
    }

    public function test_news_show_ok_when_slug_exists(): void
    {
        $news = $this->createPublishedNews();
        $this->get(route('news.show', ['slug' => $news->slug]))->assertOk();
    }

    public function test_news_show_404_when_slug_not_found(): void
    {
        $this->get(route('news.show', ['slug' => 'nope-'.uniqid()]))->assertNotFound();
    }

    public function test_merchandise_index_ok(): void
    {
        $this->get(route('merchandise.index'))->assertOk();
    }

    public function test_merchandise_show_ok_when_slug_exists(): void
    {
        $m = $this->createMerchandise();
        $this->get(route('merchandise.show', ['slug' => $m->slug]))->assertOk();
    }

    public function test_merchandise_show_404_when_slug_not_found(): void
    {
        $this->get(route('merchandise.show', ['slug' => 'nope-'.uniqid()]))->assertNotFound();
    }

    public function test_member_register_get_ok(): void
    {
        $this->get(route('member.register'))->assertOk();
    }

    public function test_member_login_get_ok(): void
    {
        $this->get(route('member.login'))->assertOk();
    }

    public function test_member_forgot_password_get_ok(): void
    {
        $this->get(route('member.password.forgot'))->assertOk();
    }
}
