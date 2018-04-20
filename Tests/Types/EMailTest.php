<?php
/**
 * User: Anton Buz (TheHett)
 * Date: 26.03.2018
 * Time: 21:24
 */

declare(strict_types=1);

namespace App\Tests\Types;

use PHPUnit\Framework\TestCase;
use ValueObjectsBundle\Type\EMail;

class EMailTest extends TestCase
{
    /**
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testMain(): void
    {
        $email = new EMail('test@example.test');
        $this->assertEquals('test@example.test', $email->getValue(), 'getValue() must return the original value');
        $this->assertEquals('test@example.test', (string)$email, 'Casted to string `EMail` must be the original value');
    }

    /**
     * @expectedException \ValueObjectsBundle\Exception\TypeCastException
     * @throws \ValueObjectsBundle\Exception\TypeCastException
     */
    public function testIncorrectData(): void
    {
        new EMail('incorrectEMailFormat@@example.test');
    }

}
