<?php
/**
 * User: Anton Buz (TheHett)
 * Date: 26.03.2018
 * Time: 21:24
 */

declare(strict_types=1);

namespace App\Tests\Types;

use PHPUnit\Framework\TestCase;
use ValueObjectsBundle\Type\Boolean;

class BooleanTest extends TestCase
{
    /**
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testValidValue(): void
    {
        $boolean = new Boolean('true');
        $this->assertTrue($boolean->getValue(), '`true` must converted correct `bool` value');

        $boolean = new Boolean('FALSE');
        $this->assertFalse($boolean->getValue(), '`FALSE` must converted correct `bool` value');

        $boolean = new Boolean('On');
        $this->assertTrue($boolean->getValue(), '`On` must converted correct `bool` value');

        $boolean = new Boolean('off');
        $this->assertFalse($boolean->getValue(), '`off` must converted correct `bool` value');

        $boolean = new Boolean('0');
        $this->assertFalse($boolean->getValue(), '`0` must converted correct `bool` value');

        $boolean = new Boolean('1');
        $this->assertTrue($boolean->getValue(), '`1` must converted correct `bool` value');
    }


    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectValue(): void
    {
        new Boolean('test');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testEmptyValue(): void
    {
        new Boolean('');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testNullValue(): void
    {
        new Boolean(null);
    }

}
