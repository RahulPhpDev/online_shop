<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NotFoundReponseEnum extends Enum
{
   
   public static function response()
   {
   	return [
   		'result' => 0,
   		'msg' => 'Not found',
   		'data' => null
   	];
   }
}
