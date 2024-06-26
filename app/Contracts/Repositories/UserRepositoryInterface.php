<?php
declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Http\Resources\User\UserResource;
use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get user by email
     *
     * @param string $email
     * @return UserResource|null
     */
    public function getResourceByEmail(string $email): ?UserResource;

    /**
     * Get user by id
     *
     * @param int $id
     * @return UserResource|null
     */
    public function getResourceById(int $id): ?UserResource;

    /**
     * Get user by id
     *
     * @param int $id
     * @return User
     */
    public function getById(int $id): User;

    /**
     * Deduct balance amount
     *
     * @param int $id
     * @param float $amount
     *
     * @return void
     */
    public function deductBalance(int $id, float $amount): void;

    /**
     * Deduct balance amount
     *
     * @param int $id
     * @param float $amount
     *
     * @return void
     */
    public function increaseBalance(int $id, float $amount): void;

    /**
     * Save new user, if user exists update it
     *
     * @param array $data
     * @return UserResource
     */
    public function save(array $data): UserResource;
}
