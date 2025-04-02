<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Auth\LogoutUseCase;
use App\UseCases\Auth\ChangePasswordUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private LoginUseCase $loginUseCase,
        private LogoutUseCase $logoutUseCase,
        private ChangePasswordUseCase $changePasswordUseCase
    ) {}

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->loginUseCase->execute($credentials);

        return response()->json($result);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->logoutUseCase->execute($request->user());

        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}
