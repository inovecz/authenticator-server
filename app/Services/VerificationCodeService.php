<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class VerificationCodeService
{
    public function verifyCode(User $user, string $code): bool
    {
        $verificationCode = $user->verificationCode;
        if ($verificationCode && $verificationCode->getCode() === $code) {
            $verificationCode->delete();
            return true;
        }
        return false;
    }
}
