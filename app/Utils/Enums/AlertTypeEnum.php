<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum AlertTypeEnum: string
{
    use EnumToArray;

    case Default = '';
    case Error = 'alert-error';
    case Warning = 'alert-warning';
    case Info = 'alert-info';
    case Success = 'alert-success';
}
