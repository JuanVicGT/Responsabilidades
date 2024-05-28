<?php

namespace App\Utils\Enums;

enum AlertIcon: string
{
    case DEFAULT = 'o-home';
    case ERROR = 'o-x-circle';
    case WARNING = 'o-exclamation-circle';
    case INFO = 'o-information-circle';
    case SUCCESS = 'o-check-circle';
}
