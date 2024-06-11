<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum StatusEvent: string
{
    use EnumToArray;

    case Active = 'active';
    case Cancelled = 'cancelled';
    case Finished = 'finished';
}
