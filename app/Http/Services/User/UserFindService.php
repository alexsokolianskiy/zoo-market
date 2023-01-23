<?php

namespace App\Http\Services\User;

use App\Models\User\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserFindService
{
    public function find(string $email): User
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new HttpException(404, 'User not found');
        }

        return $user;
    }
}
