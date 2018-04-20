<?php
/**
 * User: Anton Buz (TheHett)
 * Date: 26.03.2018
 * Time: 21:24
 */

declare(strict_types=1);

namespace ValueObjectsBundle\Type;


use ValueObjectsBundle\Exception\TypeCastException;

class Ip
{
    /** @var string binary ip address */
    private $value;

    /**
     * Ip constructor.
     * @param string $value
     * @throws TypeCastException
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new TypeCastException("Can not cast value to Ip address. '{$value}' is not an valid IPv4/v6 address");
        }
        $this->value = inet_pton($value);
    }

    public function __toString(): string
    {
        return (string)inet_ntop($this->value);
    }

    public function getPrintable(): string
    {
        return inet_ntop($this->value);
    }

    public function getBinary(): string
    {
        return $this->value;
    }

    public function isV4(): bool
    {
        return filter_var(inet_ntop($this->value), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public function isV6(): bool
    {
        return filter_var(inet_ntop($this->value), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

}