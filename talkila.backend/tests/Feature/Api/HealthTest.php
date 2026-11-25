<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

/**
 * GET /v1/health is what the deploy smoke test and uptime checks call.
 */
class HealthTest extends TestCase
{
    public function test_health_reports_app_and_database_ok(): void
    {
        $response = $this->getJson('/v1/health');

        $response->assertOk()
            ->assertExactJson(['status' => 'ok', 'database' => 'ok']);
    }

    public function test_health_rejects_writes(): void
    {
        $this->postJson('/v1/health')->assertStatus(405);
    }
}
