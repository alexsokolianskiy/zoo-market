<?php

namespace App\Http\Controllers\API\Auth;

use Throwable;
use App\Http\Controllers\Controller;
use App\Http\Services\User\UserFindService;
use App\Http\Services\User\PasswordResetService;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordConfirmRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ForgotPasswordController extends Controller
{
    public function __construct(
        private UserFindService $userFindService,
        private PasswordResetService $passwordResetService
    ) {
    }

    public function forgotRequest(ForgotPasswordRequest $request): JsonResponse
    {
        $user = $this->userFindService->find($request->get('email'));
        $token = $this->passwordResetService->resetPasswordRequest($user);

        return response()->json([
            'reset-token' => $token
        ]);
    }

    public function forgotConfirm(ForgotPasswordConfirmRequest $request): JsonResponse
    {
        try {
            $this->passwordResetService->confirmReset($request->get('token'), $request->get('password'));
        } catch (Throwable) {
            throw new HttpException(403, 'wrong token');
        }

        return response()->json();
    }
}
