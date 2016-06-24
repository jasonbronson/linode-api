<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode;

use Linode\LinodeClient;

class AbstactObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var LinodeClient */
    private $client;

    protected function setUp()
    {
        $this->client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
    }

    public function testConstructorValidData()
    {
        $object = new TestObject($this->client, ['flag' => true]);

        self::assertTrue($object->flag);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should be of type bool.
     */
    public function testConstructorInvalidData()
    {
        new TestObject($this->client, ['flag' => 'true']);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should not be null.
     */
    public function testConstructorEmptyData()
    {
        new TestObject($this->client);
    }

    public function testExistingProperty()
    {
        /** @var \StdClass $object */
        $object = new TestObject($this->client, ['flag' => true]);

        self::assertTrue(isset($object->flag));
        self::assertTrue($object->flag);

        $object->flag = false;

        self::assertFalse($object->flag);
    }

    public function testUnknownProperty()
    {
        /** @var \StdClass $object */
        $object = new TestObject($this->client, ['flag' => true]);

        self::assertFalse(isset($object->unknown));
        self::assertNull($object->unknown);

        $object->unknown = true;

        self::assertFalse(isset($object->unknown));
        self::assertNull($object->unknown);
    }
}
