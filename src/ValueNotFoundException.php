<?php declare(strict_types=1);

namespace PetrKnap\Enum;

class ValueNotFoundException extends EnumException
{
    public function __construct(
        string $enum,
        private mixed $value
    ) {
        parent::__construct($enum, sprintf('Value not found in %s', $enum));
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
