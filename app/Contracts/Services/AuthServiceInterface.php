<?php
declare(strict_types=1);

namespace App\Contracts\Services;

use App\Http\Resources\User\UserResource;

interface AuthServiceInterface
{
    /**
     * Perform login action and return token if success
     *
     * @param array $credentials
     * @return string|null
     */
    public function login(array $credentials): ?string;

    /**
     * Perform register action
     *
     * @param array $userData
     * @return mixed
     */
    public function register(array $userData): UserResource;

    /**
     * Destroy current token
     *
     * @return void
     */
    public function logout(): void;
}
