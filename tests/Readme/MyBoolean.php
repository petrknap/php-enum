<?php

namespace PetrKnap\Enum\Readme;

use PetrKnap\Enum\Enum;
use PetrKnap\Enum\ConstantsAsMembersTrait;

/**
 * @method static MyBoolean MY_TRUE()
 * @method static MyBoolean MY_FALSE()
 */
class MyBoolean extends Enum
{
    use ConstantsAsMembersTrait;

    public const MY_TRUE = 1;
    public const MY_FALSE = 2;
}
