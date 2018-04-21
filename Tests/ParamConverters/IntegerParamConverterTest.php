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
use ValueObjectsBundle\ParamConverter\IntegerParamConverter;
use ValueObjectsBundle\Type\Integer;

class IntegerParamConverterTest extends TestCase
{
    /** @var IntegerParamConverter */
    private $converter;

    public function setUp()
    {
        $this->converter = new IntegerParamConverter();
    }

    public function testSupports()
    {
        $config = $this->createConfiguration(Integer::class);
        $this->assertTrue($this->converter->supports($config));

        $config = $this->createConfiguration(__CLASS__);
        $this->assertFalse($this->converter->supports($config));

        $config = $this->createConfiguration();
        $this->assertFalse($this->converter->supports($config));
    }

    public function testApplyValidIntegerValue()
    {
        $request = new Request([], [], ['integer' => '127']);
        $config = $this->createConfiguration(Integer::class, 'integer');

        $this->converter->apply($request, $config);

        $this->assertInstanceOf(Integer::class, $request->attributes->get('integer'));
        $this->assertEquals(127, $request->attributes->get('integer')->getValue());
    }


    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testApplyInvalidIntegerValue400Exception()
    {
        $request = new Request([], [], ['integer' => '127.1']);
        $config = $this->createConfiguration(Integer::class, 'integer');

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
