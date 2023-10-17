<?php declare(strict_types=1);

namespace PetrKnap\Enum;

class MemberNotFoundException extends EnumException
{
    public function __construct(
        string $enum,
        private string $member
    ) {
        parent::__construct($enum, sprintf('Member %s not found in %s', $member, $enum));
    }

    public function getMember(): string
    {
        return $this->member;
    }
}
