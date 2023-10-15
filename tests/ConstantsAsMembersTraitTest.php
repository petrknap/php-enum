<?php

namespace PetrKnap\Enum\Test;

use PetrKnap\Enum\ConstantsAsMembersTrait;
use PHPUnit\Framework\TestCase;

class ConstantsAsMembersTraitTest extends TestCase
{
    public function testGetMembersWorks()
    {
        $this->assertEquals(
            [
                'ONE' => 1,
                'TWO' => 2,
            ],
            (new class () {
                use ConstantsAsMembersTrait;

                protected const ONE = 1;
                protected const TWO = 2;
            })::getMembers()
        );
    }
}
