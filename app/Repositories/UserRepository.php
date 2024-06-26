<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        private readonly User $user
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getResourceByEmail(string $email): ?UserResource
    {
        $user = $this->user->where('email', $email)->first();
        if (!$user) {
            return null;
        }
        return new UserResource($user);
    }

    /**
     * @inheritDoc
     */
    public function save(array $data): UserResource
    {
        return new UserResource($this->user->updateOrCreate($data, $data));
    }

    /**
     * @inheritDoc
     */
    public function getResourceById(int $id): ?UserResource
    {
        $user = $this->user->where('id', $id)->first();
        if (!$user) {
            return null;
        }
        return new UserResource($user);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): User
    {
        return $this->user->where('id', $id)->first();
    }

    public function deductBalance(int $id, float $amount): void
    {
        $this->user->where('id', $id)->decrement('balance', $amount);
    }

    public function increaseBalance(int $id, float $amount): void
    {
        $this->user->where('id', $id)->increment('balance', $amount);
    }
}
