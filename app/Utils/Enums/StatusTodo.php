<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum StatusTodo: string
{
    use EnumToArray;

    case NotStarted = 'not_started';
    case Started = 'started';
    case Cancelled = 'cancelled';
    case Finished = 'finished';
}
