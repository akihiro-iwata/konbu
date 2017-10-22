<?php
namespace Konbu\Enum;
use InvalidArgumentException;
use ReflectionObject;

abstract class Enum
{
    private $scalar;

    public function __construct($value)
    {
        $ref = new ReflectionObject($this);
        $constants = $ref->getConstants();
        if (! in_array($value, $constants, true)) {
            throw new InvalidArgumentException("vale ${$value} is not defined");
        }
        $this->scalar = $value;
    }

    final public static function __callStatic($label, $args)
    {
        $class = get_called_class();
        $const = constant("$class::$label");
        return new $class($const);
    }

    final public function valueOf()
    {
        return $this->scalar;
    }

    final public function __toString()
    {
        return (string)$this->scalar;
    }
}