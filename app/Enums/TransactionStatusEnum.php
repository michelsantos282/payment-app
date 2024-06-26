<?php
declare(strict_types=1);

namespace App\Enums;

enum TransactionStatusEnum: int
{
    case SUCCESS = 1;
    case FAIL = 2;
}
