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
use ValueObjectsBundle\ParamConverter\BooleanParamConverter;
use ValueObjectsBundle\Type\Boolean;

class BooleanParamConverterTest extends TestCase
{
    /** @var BooleanParamConverter */
    private $converter;

    public function setUp()
    {
        $this->converter = new BooleanParamConverter();
    }

    public function testSupports()
    {
        $config = $this->createConfiguration(Boolean::class);
        $this->assertTrue($this->converter->supports($config));

        $config = $this->createConfiguration(__CLASS__);
        $this->assertFalse($this->converter->supports($config));

        $config = $this->createConfiguration();
        $this->assertFalse($this->converter->supports($config));
    }

    public function testApplyBoolean()
    {
        $request = new Request([], [], ['boolean' => 'True']);
        $config = $this->createConfiguration(Boolean::class, 'boolean');

        $this->converter->apply($request, $config);

        $this->assertInstanceOf(Boolean::class, $request->attributes->get('boolean'));
        $this->assertTrue($request->attributes->get('boolean')->getValue());
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testApplyInvalidBoolean400Exception()
    {
        $request = new Request([], [], ['boolean' => 'test']);
        $config = $this->createConfiguration(Boolean::class, 'boolean');

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
