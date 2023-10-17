<?php declare(strict_types=1);

namespace PetrKnap\Enum;

interface MemberInterface
{
    public function getName(): string;

    public function getValue(): mixed;
}
