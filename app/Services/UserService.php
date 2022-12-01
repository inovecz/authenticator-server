<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function updateOrCreate(array $data, ?string $hash = null): User
    {
        if (isset($hash)) {
            $user = User::where('hash', $hash)->first();
            $user->update($data);
        } else {
            $user = User::create($data);
        }
        return $user;
    }
}
