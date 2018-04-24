<?php
/**
 * Created by PhpStorm.
 * User: "Anton Buz (TheHett)"
 * Date: 21.04.2018
 * Time: 19:45
 */

declare(strict_types=1);

namespace ValueObjectsBundle\Type;


use ValueObjectsBundle\Exception\TypeCastException;

class Boolean
{
    /** @var bool */
    private $value;

    /**
     * Boolean constructor.
     * @param string|bool|null $value
     * @throws TypeCastException
     */
    public function __construct($value)
    {
        if (\is_bool($value)) {
            $this->value = $value;
        } else {
            $value = strtolower((string)$value);
            if (false === self::validate($value)) {
                throw new TypeCastException('Can not cast value to Boolean. '
                    . "'{$value}' is not an valid Boolean");
            }
            $this->value = \filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue() ? 'true' : 'false';
    }

    /**
     * @param string $value
     * @return bool true if `value` is valid boolean (`true`, `false`, `on`, `off`, `0`, `1`) otherwise return false
     */
    public static function validate($value): bool
    {
        return \in_array(strtolower($value), [
            'true',
            'false',
            'on',
            'off',
            '0',
            '1',
        ], true);
    }

}