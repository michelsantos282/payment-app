<?php
declare(strict_types=1);

namespace App\Services\Transaction;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\TransactionServiceInterface;
use App\Enums\TransactionStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionService implements TransactionServiceInterface
{

    private const API_AUTHORIZE = 'https://util.devi.tools/api/v2/authorize';
    private const API_NOTIFY = 'https://util.devi.tools/api/v1/notify';
    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function transaction(array $transactionData): array
    {
        $payer = $this->userRepository->getById($transactionData['payer_id']);
        if ($payer->type == UserTypeEnum::SHOPKEEPER) {
            return [
                'message' => 'You are not allowed to create transactions',
                'success' => false,
                'errors' => ['The payer is a shopkeeper and can\'t create transactions'],
                'status' => 403,
            ];
        }

        $amount = $transactionData['amount'];
        if ($payer->balance < $amount) {
            return [
                'message' => 'You do not have sufficient balance',
                'success' => false,
                'errors' => ['The payer does not have sufficient balance'],
                'status' => 400
            ];
        }
        return $this->makeTransaction($transactionData);
    }

    /**
     * Create the transaction
     *
     * @param array $transactionData
     * @return array
     */
    private function makeTransaction(array $transactionData): array
    {
        DB::beginTransaction();
        $this->userRepository->deductBalance($transactionData['payer_id'], $transactionData['amount']);
        $this->userRepository->increaseBalance($transactionData['payee_id'], $transactionData['amount']);
        $authorize = $this->authorize();
        if (!$authorize) {
            DB::rollBack();
            return [
                'message' => 'Unauthorized Payment',
                'success' => false,
                'errors' => [],
                'status' => 400
            ];
        }
        $transaction = $this->transactionRepository->save([
            'payer_id' => $transactionData['payer_id'],
            'payee_id' => $transactionData['payer_id'],
            'amount' => $transactionData['amount'],
            'status' => TransactionStatusEnum::SUCCESS,
        ]);
        $transaction->save();
        DB::commit();
        return [
            'message' => 'Successful Payment',
            'success' => true,
            'status' => 200
        ];
    }

    /**
     * Sends a request to an api that verifies if the payment is authorized
     *
     * @return bool
     */
    private function authorize(): bool
    {
        $response = Http::get('https://util.devi.tools/api/v2/authorize');
        if ($response->successful()) {
            return true;
        }
        return false;
    }
}
