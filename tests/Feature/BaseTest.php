<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    use RefreshDatabase;

    protected string $userToken = '';

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function loginUser(): void
    {
        if ($this->userToken) {
            return;
        }

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->userToken = $response->json('token');
    }
}
