<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode\Internal;

use Linode\LinodeClient;

class AbstractObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var LinodeClient */
    private $client;

    protected function setUp()
    {
        $this->client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
    }

    public function testConstructorValidData()
    {
        /** @var \StdClass $object */
        $object = new TestImmutableObject($this->client, ['flag' => true]);

        self::assertTrue(isset($object->flag));
        self::assertFalse(isset($object->unknown));

        self::assertTrue($object->flag);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should be of type bool.
     */
    public function testConstructorInvalidData()
    {
        new TestImmutableObject($this->client, ['flag' => 'true']);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should not be null.
     */
    public function testConstructorEmptyData()
    {
        new TestImmutableObject($this->client);
    }

    public function testMutableProperty()
    {
        $object       = new TestMutableObject($this->client, ['flag' => true]);
        $object->flag = false;

        self::assertFalse($object->flag);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage This object is immutable.
     */
    public function testImmutableProperty()
    {
        $object       = new TestImmutableObject($this->client, ['flag' => true]);
        $object->flag = false;
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should not be null.
     */
    public function testMutablePropertyException()
    {
        $object       = new TestMutableObject($this->client, ['flag' => true]);
        $object->flag = null;
    }

    public function testGetEndpoint()
    {
        $method = new \ReflectionMethod(TestImmutableObject::class, 'getEndpoint');
        $method->setAccessible(true);

        $object = new TestImmutableObject($this->client, ['flag' => true]);
        self::assertEquals('/flags', $method->invoke($object));
    }
}
