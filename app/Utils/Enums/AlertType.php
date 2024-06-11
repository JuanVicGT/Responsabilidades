<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum AlertType: string
{
    use EnumToArray;

    case Default = '';
    case Error = 'alert-danger';
    case Warning = 'alert-warning';
    case Info = 'alert-info';
    case Success = 'alert-success';
}
