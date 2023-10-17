<?php

declare(strict_types=1);

namespace App\Services\External\Aggregator;

use App\Models\Traits\EnumToArray;

enum TimeInterval: string
{
    use EnumToArray;

    case ONE_MINUTE = '1min';
    case FIVE_MINUTES = '5min';
    case FIFTEEN_MINUTES = '15min';
    case THIRTY_MINUTES = '30min';
    case SIXTY_MINUTES = '60min';
}
