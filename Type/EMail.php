<?php
/**
 * User: "Anton Buz (TheHett)"
 * Date: 20.04.2018
 * Time: 16:53
 */

declare(strict_types=1);

namespace ValueObjectsBundle\Type;


use ValueObjectsBundle\Exception\TypeCastException;

class EMail
{
    /** @var string email */
    private $value;

    /**
     * EMail constructor.
     * @param string $value
     * @throws TypeCastException
     */
    public function __construct(string $value)
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new TypeCastException("Can not cast value to EMail address. '{$value}' is not an valid EMail address");
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}