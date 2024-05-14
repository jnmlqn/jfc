<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function __construct(
        private User $user
    ) {
        $this->user = $user;
    }

    public function createLoginToken(
        string $email,
        string $password
    ): string {
        $user = $this->user
            ->where('email', $email)
            ->firstOrFail();

        if (!Hash::check($password, $user->password)) {
            throw new Exception('Incorrect password');
        }

        return $user->createToken(
            'basic', 
            ['general'],
            now()->addDay()
        )->plainTextToken;
    }
}
