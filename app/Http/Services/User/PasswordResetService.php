<?php

namespace App\Http\Services\User;

use App\Models\User\User;
use App\Mail\User\ChangeTmpPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Passwords\PasswordBroker;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PasswordResetService
{
    public function createPasswordResetToken(User $user): string
    {
        $token = app(PasswordBroker::class)->createToken($user);

        return $token;
    }

    public function resetPasswordRequest(User $user): void
    {
        $token = $this->createPasswordResetToken($user);
        Mail::to($user->email)->send(new ChangeTmpPassword($token));
    }

    public function confirmReset(string $token, string $password): void
    {
        $user = app(PasswordBroker::class)->validateReset([
            'token' => $token
        ]);
        if (!($user instanceof User)) {
            throw new HttpException(404, 'Token not found');
        }

        $user->password = password_hash($password, PASSWORD_BCRYPT);
        $user->save();
        app(PasswordBroker::class)->deleteToken($user);
    }
}
