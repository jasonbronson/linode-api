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

use Linode\Datacenter;

class DatacenterTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(Datacenter::class);

        /** @var Datacenter $datacenter */
        $datacenter = $reflectionClass->newInstanceWithoutConstructor();
        self::assertEquals('/datacenters', $datacenter->getEndpoint());

        $this->setProperty($datacenter, 'id', $id);
        self::assertEquals('/datacenters/' . $id, $datacenter->getEndpoint());
    }
}
