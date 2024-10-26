<?php

namespace App\Utils\Enums;

use App\Utils\Traits\EnumToArray;

enum ResponsabilitySheetStatusEnum: string
{
    use EnumToArray;

    case Open = 'open';
    case Finished = 'finished';
    case Transferred = 'transferred';
    case Closed = 'closed';
}
