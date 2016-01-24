<?php

namespace PetrKnap\Php\Enum;

/**
 * Abstract enum object
 *
 * @author  Petr Knap <dev@petrknap.cz>
 * @since   2016-01-23
 * @package PetrKnap\Php\Enum
 * @version 0.4
 * @license https://github.com/petrknap/php-enum/blob/master/LICENSE MIT
 */
abstract class AbstractEnum
{
    /**
     * @var self[][]
     */
    private static $instances;

    /**
     * @var mixed[][]
     */
    private static $members = [];

    /**
     * @var string
     */
    private $memberName;

    /**
     * @var mixed
     */
    private $memberValue;

    /**
     * @param string $memberName
     * @throws EnumException
     */
    private function __construct($memberName)
    {
        $members = &self::$members[get_called_class()];

        if (!$members) {
            $members = $this->members();
        }

        if (!($memberName === null && !$this->exists(null))) {
            $this->memberName = $memberName;
            $this->memberValue = $this->get($memberName);
        }
    }

    /**
     * Creates magical factories for easier access to enum
     *
     * @param string $memberName enum key
     * @param array $args ignored
     * @return mixed
     */
    public static function __callStatic($memberName, array $args)
    {
        $className = get_called_class();

        $instances = &self::$instances[$className];

        if (!is_array($instances)) {
            $instances = [];
        }

        $instance = &$instances[$memberName];

        if (!($instance instanceof $className)) {
            $instance = new $className($memberName);
        }

        return $instance;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->memberName;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->memberValue;
    }

    /**
     * @return mixed[] [first_name => first_value, second_name => second_value,...]
     */
    abstract protected function members();

    /**
     * @return mixed[]
     */
    public static function getMembers()
    {
        $className = get_called_class();

        $members = &self::$members[$className];

        if (empty($members)) {
            new $className(null);
        }

        return $members;
    }

    /**
     * @param string $memberName
     * @return bool
     */
    private function exists($memberName)
    {
        return array_key_exists($memberName, self::$members[get_called_class()]);
    }

    /**
     * @param string $memberName
     * @return mixed
     * @throws EnumException
     */
    private function get($memberName)
    {
        if (!$this->exists($memberName)) {
            throw new EnumException(
                sprintf(
                    "%s does not exist in %s",
                    $memberName,
                    get_called_class()
                ),
                EnumException::OUT_OF_RANGE
            );
        }

        return self::$members[get_called_class()][$memberName];
    }
}