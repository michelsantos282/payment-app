<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    use HttpResponse;
    public function __construct(
        private readonly AuthServiceInterface $authService,
    ) {
    }

    /**
     * Perform register action
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function index(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->only('email','name', 'cpf_cnpj', 'password');
        $userData = $this->authService->register($credentials);
        return $this->response(
            'User registered successfully',
            200,
            [$userData]
        );
    }
}
