<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\Welcome;

class AuthService
{
    public function register(array $data): array
    {
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $token = $user->createToken('authToken')->plainTextToken;

        $user->notify(new Welcome);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials): array
    {
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $user->tokens()->delete();
            $token = $user->createToken('authToken')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        }

        return [
            'message' => 'Invalid Credentials'
        ];
    }
}
