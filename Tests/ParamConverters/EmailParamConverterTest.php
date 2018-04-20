<?php
/**
 * User: Anton Buz (TheHett)
 * Date: 26.03.2018
 * Time: 21:24
 */

declare(strict_types=1);

namespace App\Tests\ParamConverters;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use ValueObjectsBundle\ParamConverter\EMailParamConverter;
use ValueObjectsBundle\Type\EMail;

class EmailParamConverterTest extends TestCase
{
    /** @var EMailParamConverter */
    private $converter;

    public function setUp()
    {
        $this->converter = new EMailParamConverter();
    }

    public function testSupports()
    {
        $config = $this->createConfiguration(EMail::class);
        $this->assertTrue($this->converter->supports($config));

        $config = $this->createConfiguration(__CLASS__);
        $this->assertFalse($this->converter->supports($config));

        $config = $this->createConfiguration();
        $this->assertFalse($this->converter->supports($config));
    }

    public function testApplyEMail()
    {
        $request = new Request([], [], ['email' => 'test@example.test']);
        $config = $this->createConfiguration(EMail::class, 'email');

        $this->converter->apply($request, $config);

        $this->assertInstanceOf(EMail::class, $request->attributes->get('email'));
        $this->assertEquals('test@example.test', $request->attributes->get('email')->getValue());
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testApplyInvalidEMail404Exception()
    {
        $request = new Request([], [], ['email' => 'incorrectEMailFormat@@example.test']);
        $config = $this->createConfiguration(EMail::class, 'email');

        $this->converter->apply($request, $config);
    }


    /**
     * @param null $class
     * @param null $name
     * @return \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter
     */
    public function createConfiguration($class = null, $name = null)
    {
        $config = $this
            ->getMockBuilder('Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter')
            ->setMethods(['getClass', 'getAliasName', 'getOptions', 'getName', 'allowArray', 'isOptional'])
            ->disableOriginalConstructor()
            ->getMock();

        if (null !== $name) {
            $config->expects($this->any())
                ->method('getName')
                ->will($this->returnValue($name));
        }
        if (null !== $class) {
            $config->expects($this->any())
                ->method('getClass')
                ->will($this->returnValue($class));
        }

        return $config;
    }
}
