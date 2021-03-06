<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ResponseMessages extends Enum
{
    const REGISTERED =  'REGISTERED';
    const NOTVALID =   'validation failed';
    const CARTRESPONSE = 'Cart Date';
    const PAGES = 'pages';
    const EMPTY  = 'empty';
    const SUCCESS = 'success';
}
