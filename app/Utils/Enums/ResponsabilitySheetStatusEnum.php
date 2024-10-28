<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum ResponsabilitySheetStatusEnum: string
{
    use EnumToArray;

    case Open = 'open';
    case Canceled = 'canceled';
    case Transferred = 'transferred';
    case Received = 'received';
    case Modified = 'modified';
    case Closed = 'closed';
}
