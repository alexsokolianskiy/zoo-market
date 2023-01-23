<?php

namespace App\Http\Services\User;

use App\Models\User\User;
use Laravel\Sanctum\NewAccessToken;

class Auth
{
    public function createUserToken(User $user, string $provider = 'default'): NewAccessToken
    {
        return $user->createToken($provider);
    }
}
