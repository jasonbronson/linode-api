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

class MutableObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var LinodeClient */
    private $client;

    protected function setUp()
    {
        $this->client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [id] This property is immutable.
     */
    public function testImmutableId()
    {
        $object     = new MutableObjectStub($this->client, ['flag' => true]);
        $object->id = 'test';
    }

    public function testMutableProperty()
    {
        $object       = new MutableObjectStub($this->client, ['flag' => true]);
        $object->flag = false;

        self::assertFalse($object->flag);
    }

    /**
     * @expectedException \Linode\ValidationException
     * @expectedExceptionMessage [flag] This value should not be null.
     */
    public function testMutablePropertyException()
    {
        $object       = new MutableObjectStub($this->client, ['flag' => true]);
        $object->flag = null;
    }
}
