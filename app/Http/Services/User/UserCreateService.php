<?php

namespace App\Http\Services\User;

use App\Models\User\User;
use Illuminate\Support\Str;

class UserCreateService
{
    public function __construct(
        private PasswordResetService $passwordResetService
    ) {
    }

    public function create(
        string $name = null,
        string $lastName = null,
        string $phone = null,
        string $email = null,
        string $password = null
    ): User {
        $newUser = new User();
        $newUser->name = $name;
        $newUser->last_name = $lastName;
        $newUser->email = $email;
        $newUser->phone = $phone;
        $usrPswd = $password ?? Str::random(20);
        $newUser->password = password_hash($usrPswd, PASSWORD_BCRYPT);
        $newUser->save();
        if (is_null($password) && $email) {
            $this->passwordResetService->resetPasswordRequest($newUser);
        }

        return $newUser;
    }
}
