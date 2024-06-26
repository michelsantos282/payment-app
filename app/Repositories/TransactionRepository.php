<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(
        private readonly Transaction $transaction
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(array $data): void
    {
        $this->transaction->create($data);
    }
}
