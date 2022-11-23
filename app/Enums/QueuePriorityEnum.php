<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumTrait;

enum QueuePriorityEnum: string
{
    use EnumTrait;

    case TOP = 'top'; // two factor emails, etc
    case HIGH = 'high';
    // here is default priority : php artisan queue:work --queue=top,high,default,low
    case LOW = 'low'; // jobs running through the night, etc.
}
