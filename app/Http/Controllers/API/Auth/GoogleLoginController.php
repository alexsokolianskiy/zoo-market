<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User\User;
use App\Http\Services\User\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Services\User\UserCreateService;
use App\Http\Resources\Auth\AuthTokenResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GoogleLoginController extends Controller
{
    public function __construct(private UserCreateService $userCreateService)
    {
    }

    public function google(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback(Auth $auth): JsonResponse
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            throw new HttpException(404, 'User not found');
        }
        $existingUser = User::where('email', $user->email)->first();
        if (!$existingUser) {
            // create a new user
            $splittedName = explode(' ', $user->name);
            $newUser = $this->userCreateService->create(
                $splittedName[0] ?? null,
                $splittedName[1] ?? null,
                null,
                $user->email
            );
            $existingUser = $newUser;
        }
        $token = $auth->createUserToken($existingUser, 'google');

        return response()->json(new AuthTokenResource($token));
    }
}
