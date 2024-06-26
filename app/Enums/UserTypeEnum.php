<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * Enum with all user types
 */
enum UserTypeEnum: int
{
    case USER = 1;
    case SHOPKEEPER = 2;
}
