<?php declare(strict_types=1);

namespace PetrKnap\Enum;

use PetrKnap\Shorts\ArrayShorts;
use Stringable;

/** @phpstan-consistent-constructor */
abstract class Enum implements MemberInterface, Stringable
{
    /** @var array<string, static> */
    protected static ?array $instances = null;

    protected function __construct(
        private string $name,
        private mixed $value
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /** @return array<string, mixed> */
    abstract public static function getMembers(): array;

    /** @throws MemberNotFoundException */
    public static function getByName(string $name): static
    {
        static::$instances = ArrayShorts::keyMap( // @phpstan-ignore-line
            static fn ($instance) => $instance ?? new static($name, static::getMemberValue($name)),
            static::$instances ?? [],
            $name,
        );
        return static::$instances[$name]; // @phpstan-ignore-line
    }

    /** @throws ValueNotFoundException */
    public static function getByValue(mixed $value): static
    {
        foreach (static::getMembers() as $n => $v) {
            if ($value === $v) {
                return static::getByName($n);
            }
        }
        throw new ValueNotFoundException(static::class, $value);
    }

    /** @throws MemberNotFoundException */
    protected static function getMemberValue(string $name): mixed
    {
        $members = static::getMembers();
        if (!array_key_exists($name, $members)) {
            throw new MemberNotFoundException(static::class, $name);
        }
        return $members[$name];
    }

    /** @param array<mixed> $unused */
    public static function __callStatic(string $name, array $unused): static
    {
        return static::getByName($name);
    }

    public function __toString(): string
    {
        return sprintf('%s::%s', static::class, $this->getName());
    }
}
