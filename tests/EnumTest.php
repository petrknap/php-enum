<?php

namespace PetrKnap\Enum\Test;

use PetrKnap\Enum\Enum;
use PetrKnap\Enum\MemberNotFoundException;
use PetrKnap\Enum\ValueNotFoundException;
use PetrKnap\Enum\Test\Readme\MyBoolean;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    /** @dataProvider dataCallStaticWorks */
    public function testCallStaticWorks(string $name, mixed $expectedValue, string $expectedException = null)
    {
        if ($expectedException) {
            $this->expectException($expectedException);
        }

        $this->assertSame($expectedValue, MyBoolean::__callStatic($name, [])->getValue());
    }

    public function dataCallStaticWorks()
    {
        return [
            ["MY_TRUE", 1],
            ["MY_FALSE", 2],
            ["MY_NULL", null, MemberNotFoundException::class],
        ];
    }

    /** @dataProvider dataGetByValueWorks */
    public function testGetByValueWorks(mixed $value, ?Enum $expectedEnum, string $expectedException = null)
    {
        if ($expectedException) {
            $this->expectException($expectedException);
        }

        $this->assertSame($expectedEnum, MyBoolean::getByValue($value));
    }

    public function dataGetByValueWorks()
    {
        return [
            [1, MyBoolean::MY_TRUE()],
            [2, MyBoolean::MY_FALSE()],
            [3, null, ValueNotFoundException::class],
        ];
    }

    public function testComparisionWorks()
    {
        $this->assertTrue(MyBoolean::MY_TRUE() == MyBoolean::MY_TRUE());
        $this->assertFalse(MyBoolean::MY_TRUE() == MyBoolean::MY_FALSE());

        $this->assertTrue(MyBoolean::MY_TRUE() === MyBoolean::MY_TRUE());
        $this->assertFalse(MyBoolean::MY_TRUE() === MyBoolean::MY_FALSE());

        $this->assertSame(MyBoolean::MY_TRUE(), MyBoolean::MY_TRUE());
        $this->assertNotSame(MyBoolean::MY_TRUE(), MyBoolean::MY_FALSE());
    }

    public function testGetMembersWorks()
    {
        $this->assertEquals([
            "MY_TRUE" => 1,
            "MY_FALSE" => 2,
        ], MyBoolean::getMembers());
    }

    /** @dataProvider dataToStringWorks */
    public function testToStringWorks(Enum $enum, string $expectedString)
    {
        $this->assertSame($expectedString, $enum->__toString());
        $this->assertSame($expectedString, (string) $enum);
        $this->assertSame($expectedString, "{$enum}");
        $this->assertSame($expectedString, $enum . "");
    }

    public function dataToStringWorks()
    {
        return [
            [MyBoolean::MY_TRUE(), MyBoolean::class . "::MY_TRUE"],
            [MyBoolean::MY_FALSE(), MyBoolean::class . "::MY_FALSE"]
        ];
    }

    /** @dataProvider dataMixedValuesAreSupported */
    public function testMixedValuesAreSupported(Enum $enum, string $assertion)
    {
        $this->{"assert{$assertion}"}($enum->getValue());
    }

    public function dataMixedValuesAreSupported()
    {
        $mixed = new class ('test', 'test') extends Enum {
            public function __construct(...$args)
            {
                parent::__construct(...$args);
            }

            public static function getMembers(): array
            {
                return [
                    "Null" => null,
                    "IsBool" => true,
                    "IsInt" => 1,
                    "IsFloat" => 1.0,
                    "IsString" => "s",
                    "IsArray" => [],
                    "IsObject" => new \stdClass(),
                    "IsCallable" => function () {
                    },
                ];
            }
        };
        foreach ($mixed::getMembers() as $name => $ignored) {
            yield [$mixed::__callStatic($name, []), $name];
        }
    }
}
