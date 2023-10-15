<?php declare(strict_types=1);

namespace PetrKnap\Enum;

use ReflectionClass;

trait ConstantsAsMembersTrait
{
    private static ?array $members = null;

    public static function getMembers(): array
    {
        if (!self::$members) {
            $classReflection = new ReflectionClass(get_called_class());
            self::$members = $classReflection->getConstants();
        }
        return self::$members;
    }
}
