<?php

namespace Tests\Feature;

class UserTest extends BaseTest
{
    public function test_user_unauthenticated_show_request(): void
    {
        $response = $this->get(route('user.show'));

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_user_unauthenticated_update_request(): void
    {
        $response = $this->get(route('user.update'));

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_user_show_request(): void
    {
        $this->loginUser();

        $response = $this->get(route('user.show'));

        $response->assertStatus(200);
        $response->assertJson([
            'email' => 'test@example.com',
        ]);
    }

    public function test_user_update_success(): void
    {
        $this->loginUser();

        $data = [
            'language' => 'it',
            'timezone' => 'Africa/Abidjan',
        ];
        
        $response = $this->put(route('user.update'), $data);

        $response->assertStatus(200);
        $response->assertJson($data);
    }

    public function test_user_update_fail_validation(): void
    {
        $this->loginUser();
        
        $response = $this->put(route('user.update'));

        $response->assertStatus(422);
    }
}
