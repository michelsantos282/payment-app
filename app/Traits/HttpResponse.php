<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{

    public function response(string $message, int $status, array $data = []): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $status);
    }

    public function error(string $message, int $status, array $errors = [], array $data = []): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'errors' => $errors,
            'data' => $data,
        ], $status);
    }
}
