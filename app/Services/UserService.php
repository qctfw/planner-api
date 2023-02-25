<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(array $data): string
    {
        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return $this->login($data['email'], $data['password']);
    }

    public function login(string $email, string $password): string|null
    {
        /** @var \App\Models\User|null $user */
        $user = User::query()->where('email', $email)->first();
        if (!$user) {
            return null;
        }

        if (!Hash::check($password, $user->password)) {
            return null;
        }

        $token = $user->createToken('token');

        return $token->plainTextToken;
    }
}
