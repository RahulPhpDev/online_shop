<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    const PENDING =   0;
    const APPROVED =   1;
    const DISPATCHED = 2;
    const RECEIVED = 3;
    const DECLINE = 4;
}
