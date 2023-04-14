<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\Welcome;
use Illuminate\Support\Facades\Notification;

class AuthTest extends BaseTest
{
    public function test_register_success_with_notify(): void
    {
        Notification::fake();
        Notification::assertNothingSent();

        $response = $this->post(route('register'), [
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'test@test.com')->first();
        Notification::assertSentTo(
            $user,
            Welcome::class,
        );
    }

    public function test_register_fail_with_email_alrady_exists(): void
    {
        $response = $this->post(route('register'), [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The email has already been taken.',
        ]);
    }

    public function test_register_fail_validation(): void
    {
        $response = $this->post(route('register'));

        $response->assertStatus(422);
    }

    public function test_login_success(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_fail_validation(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'wrong@email.com',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_invalid_credentials(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'wrong@email.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Invalid Credentials',
        ]);
    }
}
