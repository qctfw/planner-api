<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $user_service)
    {
    }

    public function login(UserLoginRequest $request)
    {
        $token = $this->user_service->login($request->string('email'), $request->string('password'));

        if (!$token) {
            response()->json([
                'message' => 'Incorrect email or password'
            ], 401);
        }

        return response()->json([
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function register(UserRegisterRequest $request)
    {
        $token = $this->user_service->register([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'password' => $request->string('password'),
        ]);

        return response()->json([
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function show()
    {
        return response()->json([
            'data' => auth()->user()
        ]);
    }
}
