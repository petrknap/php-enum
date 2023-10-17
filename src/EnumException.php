<?php declare(strict_types=1);

namespace PetrKnap\Enum;

use Exception;

abstract class EnumException extends Exception
{
    public function __construct(
        private string $enum,
        string $message
    ) {
        parent::__construct($message);
    }

    public function getEnum(): string
    {
        return $this->enum;
    }
}
