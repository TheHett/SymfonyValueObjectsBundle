<?php
/**
 * User: Anton Buz (TheHett)
 * Date: 26.03.2018
 * Time: 21:24
 */

declare(strict_types=1);

namespace App\Tests\Types;

use PHPUnit\Framework\TestCase;
use ValueObjectsBundle\Type\Integer;

class IntegerTest extends TestCase
{
    /**
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testMain(): void
    {
        $integer = new Integer('127');
        $this->assertEquals(127, $integer->getValue(), 'getValue() must correct integer value');
        $this->assertEquals(127, (string)$integer, 'Casted to string `Integer` must be correct integer value');
        $this->assertTrue(\is_int($integer->getValue()), "getValue() must return `int` type");
    }

    /**
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testNegative(): void
    {
        $integer = new Integer('-127');
        $this->assertEquals(-127, $integer->getValue(), 'getValue() must correct integer value');
        $this->assertEquals(-127, (string)$integer, 'Casted to string `Integer` must be correct integer value');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testOutOfRangePositive(): void
    {
        new Integer(PHP_INT_MAX . '1');
    }
    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testOutOfRangeNegative(): void
    {
        new Integer('-' . PHP_INT_MAX . '1');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectValueFloat(): void
    {
        new Integer('127.1');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectValueString(): void
    {
        new Integer('127s');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectValueOctet(): void
    {
        new Integer('0x16');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectValueObject(): void
    {
        new Integer(new \stdClass());
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testEmptyValue(): void
    {
        new Integer('');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testNull(): void
    {
        new Integer(null);
    }

}
