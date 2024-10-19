<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum AlertIconEnum: string
{
    use EnumToArray;

    case Default = 'o-home';
    case Error = 'o-x-circle';
    case Warning = 'o-exclamation-circle';
    case Info = 'o-information-circle';
    case Success = 'o-check-circle';
}
