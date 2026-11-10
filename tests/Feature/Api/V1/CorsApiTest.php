<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;

class CorsApiTest extends TestCase
{
    public function test_allowed_origin_receives_cors_header(): void
    {
        config(['cors.allowed_origins' => ['https://app.example.com']]);

        $this->withHeaders([
            'Origin' => 'https://app.example.com',
            'Access-Control-Request-Method' => 'POST',
        ])
            ->options('/api/v1/auth/login')
            ->assertHeader('Access-Control-Allow-Origin', 'https://app.example.com');
    }

    public function test_unlisted_origin_receives_no_cors_header(): void
    {
        config(['cors.allowed_origins' => ['https://app.example.com']]);

        $response = $this->withHeaders([
            'Origin' => 'https://penyerang.example.net',
            'Access-Control-Request-Method' => 'POST',
        ])->options('/api/v1/auth/login');

        $this->assertNotEquals(
            'https://penyerang.example.net',
            $response->headers->get('Access-Control-Allow-Origin')
        );
    }

    public function test_no_origin_is_allowed_by_default(): void
    {
        config(['cors.allowed_origins' => []]);

        $response = $this->withHeaders([
            'Origin' => 'https://app.example.com',
            'Access-Control-Request-Method' => 'POST',
        ])->options('/api/v1/auth/login');

        $this->assertNull($response->headers->get('Access-Control-Allow-Origin'));
    }
}
