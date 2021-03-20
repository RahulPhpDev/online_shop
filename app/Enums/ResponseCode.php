<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
// https://kinsta.com/blog/http-status-codes/
/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ResponseCode extends Enum
{
    const HTTP_CONTINUE =   0;
    const HTTP_CREATED =   201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NO_RESPONSE =  204;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;

}
