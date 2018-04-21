<?php
/**
 * User: "Anton Buz (TheHett)"
 * Date: 21.04.2018
 * Time: 14:10
 */

declare(strict_types=1);

namespace ValueObjectsBundle\Type;

use ValueObjectsBundle\Exception\TypeCastException;

class Integer
{
    /** @var int value */
    private $value;

    /**
     * Integer constructor.
     * @param int|string|float $value
     * @throws TypeCastException
     */
    public function __construct($value)
    {
        if (\is_int($value)) {
            $this->value = $value;
        } else {
            try {
                $value = (string)$value;
            } catch (\Exception $e) {
                throw new TypeCastException($e->getMessage(), 0, $e);
            }
            if (filter_var($value, FILTER_VALIDATE_INT) === false) {
                throw new TypeCastException("Can not cast value to Integer. '{$value}' is not an valid integer");
            }
            if (bccomp($value, (string)PHP_INT_MAX, 0) === 1 || bccomp($value, (string)PHP_INT_MIN, 0) === -1) {
                $min = PHP_INT_MIN;
                $max = PHP_INT_MAX;
                throw new TypeCastException("Value '{$value}' is out of range [{$min}, {$max}]");
            }
            $this->value = (int)$value;
        }
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }

}