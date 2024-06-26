<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponse;
    public function __construct(
        private readonly AuthServiceInterface $authService,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Perform login action
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function index(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token = $this->authService->login($credentials);
        if (!$token) {
            return $this->error('Invalid credentials', 403);
        }
        return $this->response('Authorized', 200, ['token' => $token]);
    }

    /**
     * Perform logout action
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
       $this->authService->logout();
       return $this->response('Logged out', 200);
    }

    public function test(Request $request): JsonResponse
    {
        $requestData = $request->only('id');
        $userData = $this->userRepository->getById($requestData['id']);
        if (!$userData) {
            return $this->error('User not found', 404);
        }
        return $this->response('User returned', 200, [$userData]);
    }
}
