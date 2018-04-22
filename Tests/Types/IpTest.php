<?php
/**
 * User: Anton Buz (TheHett)
 * Date: 26.03.2018
 * Time: 21:24
 */

declare(strict_types=1);

namespace App\Tests\Types;

use PHPUnit\Framework\TestCase;
use ValueObjectsBundle\Type\Ip;

class IpTest extends TestCase
{
    /**
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testMain(): void
    {
        $ip = new Ip('127.0.0.1');
        $this->assertSame(inet_pton('127.0.0.1'), $ip->getBinary(), 'getBinary() must return `Ip` in binary format');
        $this->assertSame('127.0.0.1', (string)$ip, 'Casted to string `Ip` must be an printable value');
        $this->assertSame('127.0.0.1', $ip->getPrintable(), 'getPrintable() must return printable value');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectValue(): void
    {
        new Ip('127.0.0.1.1');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testEmptyValue(): void
    {
        new Ip('');
    }

}
