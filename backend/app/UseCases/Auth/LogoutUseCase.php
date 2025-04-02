<?php

namespace App\UseCases\Auth;

use App\Models\User;

class LogoutUseCase
{
    public function execute(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
