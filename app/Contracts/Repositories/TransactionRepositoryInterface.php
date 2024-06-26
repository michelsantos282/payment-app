<?php
declare(strict_types=1);

namespace App\Contracts\Repositories;

interface TransactionRepositoryInterface
{
    /**
     * Save the transaction
     *
     * @param array $data
     * @return void
     */
    public function save(array $data): void;
}
