<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum StatusEventEnum: string
{
    use EnumToArray;

    case Active = 'active';
    case Cancelled = 'cancelled';
    case Finished = 'finished';
}
