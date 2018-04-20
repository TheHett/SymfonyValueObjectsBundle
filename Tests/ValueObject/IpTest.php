<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use ValueObjectsBundle\Type\Ip;

class IpTest extends TestCase
{
    /**
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testConvert()
    {
        $ip = new Ip("127.0.0.1");
        $this->assertEquals(inet_pton("127.0.0.1"), $ip->getBinary(), "getBinary() must return binary value");
        $this->assertEquals("127.0.0.1", (string)$ip, "Cast to string IP must be an printable value");
        $this->assertEquals("127.0.0.1", $ip->getPrintable(), "getPrintable() must return printable value");
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectData()
    {
        new Ip("127.0.0.1.1");
    }

}
