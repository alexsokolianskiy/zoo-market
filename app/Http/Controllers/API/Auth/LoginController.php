<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Services\User\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\User\UserFindService;
use App\Http\Resources\Auth\AuthTokenResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginController extends Controller
{
    public function login(LoginRequest $request, UserFindService $userFindService, Auth $auth): JsonResponse
    {
        $user = $userFindService->find($request->get('email'));
        if ($user && password_verify($request->get('password'), $user->password)) {
            $token = $auth->createUserToken($user);
            return response()->json(new AuthTokenResource($token));
        }

        throw new HttpException(403, 'Wrong email or password');
    }
}
