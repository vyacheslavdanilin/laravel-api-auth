<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function show(Request $request): JsonResponse
    {
        return response()->json(
            $request->user()
        );
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = $this->userService->update($request);
      
        return response()->json($user);
    }
}
