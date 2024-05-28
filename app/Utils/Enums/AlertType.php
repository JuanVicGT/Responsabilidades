<?php

namespace App\Utils\Enums;

enum AlertType: string
{
    case DEFAULT = '';
    case ERROR = 'alert-danger';
    case WARNING = 'alert-warning';
    case INFO = 'alert-info';
    case SUCCESS = 'alert-success';
}
