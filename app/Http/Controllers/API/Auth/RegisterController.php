<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use App\Http\Requests\Auth\ResetTmpPasswordRequest;
use App\Http\Services\User\PasswordResetService;
use App\Http\Services\User\UserCreateService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, UserCreateService $userCreateService)
    {
        $userCreateService->create(
            $request->get('name'),
            $request->get('last_name'),
            $request->get('phone'),
            $request->get('email'),
            $request->get('password')
        );

        return response()->json();
    }

    public function confirmReset(ResetTmpPasswordRequest $request, PasswordResetService $passwordResetService)
    {
        try {
            $passwordResetService->confirmReset($request->get('token'), $request->get('password'));
        } catch (Throwable) {
            throw new HttpException(403, 'wrong token');
        }

        return response()->json();
    }
}
