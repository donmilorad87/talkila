<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Talkila');
    }

    public function test_unknown_page_returns_404(): void
    {
        $this->get('/this-page-does-not-exist-'.uniqid())->assertNotFound();
    }
}
