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

use Linode\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(Service::class);

        /** @var Service $service */
        $service = $reflectionClass->newInstanceWithoutConstructor();
        self::assertEquals('/services', $service->getEndpoint());

        $this->setProtectedProperty($service, 'id', $id);
        self::assertEquals('/services/' . $id, $service->getEndpoint());
    }
}
