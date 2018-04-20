<?php

namespace App\Tests\ParamConverter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use ValueObjectsBundle\ParamConverter\IpParamConverter;
use ValueObjectsBundle\Type\Ip;

class IpParamConverterTest extends TestCase
{
    /** @var IpParamConverter */
    private $converter;

    public function setUp()
    {
        $this->converter = new IpParamConverter();
    }

    public function testSupports()
    {
        $config = $this->createConfiguration(Ip::class);
        $this->assertTrue($this->converter->supports($config));

        $config = $this->createConfiguration(__CLASS__);
        $this->assertFalse($this->converter->supports($config));

        $config = $this->createConfiguration();
        $this->assertFalse($this->converter->supports($config));
    }

    public function testApplyIpv4()
    {
        $request = new Request([], [], ['ip' => '127.0.0.1']);
        $config = $this->createConfiguration(Ip::class, 'ip');

        $this->converter->apply($request, $config);

        $this->assertInstanceOf(Ip::class, $request->attributes->get('ip'));
        $this->assertEquals('127.0.0.1', $request->attributes->get('ip')->getPrintable());
    }

    public function testApplyIpv6()
    {
        $request = new Request([], [], ['ip' => '::1']);
        $config = $this->createConfiguration(Ip::class, 'ip');

        $this->converter->apply($request, $config);

        $this->assertInstanceOf(Ip::class, $request->attributes->get('ip'));
        $this->assertEquals('::1', $request->attributes->get('ip')->getPrintable());
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testApplyInvalidDate404Exception()
    {
        $request = new Request([], [], ['ip' => '127.0.0.1.1']);
        $config = $this->createConfiguration(Ip::class, 'ip');

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
