<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;

class UserService
{
    public function update(UpdateUserRequest $request): array
    {
        $user = $request->user();
        $user->update($request->validated());

        return $user->toArray();
    }
}
