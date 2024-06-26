<?php
declare(strict_types=1);

namespace App\Http\Controllers\Transaction;

use App\Contracts\Services\TransactionServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    use HttpResponse;

    public function __construct(
        private readonly TransactionServiceInterface $transactionService,
    ) {
    }

    /**
     * Transaction index
     *
     * @param TransactionRequest $request
     * @return JsonResponse
     */
    public function index(TransactionRequest $request): JsonResponse
    {
        $transactionData = $request->only('payer_id', 'payee_id', 'amount');

        $transactionData = $this->transactionService->transaction($transactionData);

        if (!$transactionData['success']) {
            return $this->error($transactionData['message'], $transactionData['status'], $transactionData['errors']);
        }
        return $this->response($transactionData['message'], $transactionData['status']);
    }
}
