<?php

namespace PetrKnap\Php\Enum\Test\EnumTest;

use PetrKnap\Php\Enum\Enum;

/**
 * @method static MyBoolean MY_TRUE()
 * @method static MyBoolean MY_FALSE()
 */
class MyBoolean extends Enum
{
    /**
     * @inheritdoc
     */
    protected function members()
    {
        return [
            "MY_TRUE" => 1,
            "MY_FALSE" => 2,
        ];
    }

    /**
     * Returns class name (PHP <5.5)
     *
     * @return string
     */
    public static function getClass()
    {
        return __CLASS__;
    }
}
