<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum StatusPasswordResetRequestEnum: string
{
    use EnumToArray;

    case NotVerified = 'not_verified';
    case Refused = 'refused';
    case Processed = 'processed';
}
