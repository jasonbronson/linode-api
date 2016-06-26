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

use AltrEgo\AltrEgo;
use Linode\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(Service::class);

        /** @var Service $service */
        $service = $reflectionClass->newInstanceWithoutConstructor();

        $method = new \ReflectionMethod(Service::class, 'getEndpoint');
        $method->setAccessible(true);

        self::assertFalse($method->invoke($service));

        /** @noinspection PhpParamsInspection */
        $object = AltrEgo::create($service);

        /** @var \StdClass $object */
        $object->id = $id;

        self::assertEquals('/services/' . $id, $method->invoke($service));
    }
}
