<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User\User;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\Auth\AuthTokenResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginController extends Controller
{
    public function google(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback(): JsonResponse
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            throw new HttpException(404, 'User not found');
        }
        $existingUser = User::where('email', $user->email)->first();
        if (!$existingUser) {
            // create a new user
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = password_hash(Str::random(20), PASSWORD_BCRYPT);
            $newUser->save();
            $existingUser = $newUser;
        }
        $token = $existingUser->createToken('google');

        return response()->json(new AuthTokenResource($token));
    }
}
