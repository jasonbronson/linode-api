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

class AbstactObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorValidData()
    {
        $object = new TestObject(['flag' => true]);

        self::assertTrue($object->flag);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should be of type bool.
     */
    public function testConstructorInvalidData()
    {
        new TestObject(['flag' => 'true']);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should not be null.
     */
    public function testConstructorEmptyData()
    {
        new TestObject();
    }

    public function testExistingProperty()
    {
        /** @var \StdClass $object */
        $object = new TestObject(['flag' => true]);

        self::assertTrue(isset($object->flag));
        self::assertTrue($object->flag);

        $object->flag = false;

        self::assertFalse($object->flag);
    }

    public function testUnknownProperty()
    {
        /** @var \StdClass $object */
        $object = new TestObject(['flag' => true]);

        self::assertFalse(isset($object->unknown));
        self::assertNull($object->unknown);

        $object->unknown = true;

        self::assertFalse(isset($object->unknown));
        self::assertNull($object->unknown);
    }
}
