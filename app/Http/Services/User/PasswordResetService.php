<?php

namespace App\Http\Services\User;

use App\Models\User\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\User\ChangeTmpPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Passwords\PasswordBroker;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PasswordResetService
{
    public function createPasswordResetToken(User $user): string
    {
        $token = password_hash(Str::random(40), PASSWORD_BCRYPT);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token]
        );

        return $token;
    }

    public function resetPasswordRequest(User $user): string
    {
        $token = $this->createPasswordResetToken($user);
        Mail::to($user->email)->send(new ChangeTmpPassword($token));

        return $token;
    }

    public function confirmReset(string $token, string $password): void
    {
        $email = DB::table('password_resets')->where(['token' => $token])->pluck('email')->first();
        $user = User::where(['email' => $email])->first();
        if (!$user) {
            throw new HttpException(404, 'Token not found');
        }

        $user->password = password_hash($password, PASSWORD_BCRYPT);
        $user->save();
        app(PasswordBroker::class)->deleteToken($user);
    }
}
