<?php

namespace App\Contracts\Services;

interface TransactionServiceInterface
{

    public function transaction(array $transactionData): array;
}
