<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @throws GuzzleException
     */
    public function test_deposit_in_wallet()
    {
        $appUrl = env('APP_URL');
        $client = new Client();

        $response = $client->post($appUrl.'/v1/deposite-in-wallet');
        //$response->assertStatus(200);
        $this->assertEquals(200, $response->getStatusCode(), 'Success');
    }
}
