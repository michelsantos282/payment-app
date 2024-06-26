<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly Request $request,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function login(array $credentials): ?string
    {
        if(!auth()->attempt($credentials)) return null;
        return auth()->user()->createToken('logged', ['*'], now()->addDay())->plainTextToken;
    }

    public function register(array $userData): UserResource
    {
        return $this->userRepository->save($userData);
    }

    /**
     * @inheritDoc
     */
    public function logout(): void
    {
        $this->request->user()->currentAccessToken()->delete();
    }
}
