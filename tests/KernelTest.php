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
use Linode\Kernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(Kernel::class);

        /** @var Kernel $kernel */
        $kernel = $reflectionClass->newInstanceWithoutConstructor();

        $method = new \ReflectionMethod(Kernel::class, 'getEndpoint');
        $method->setAccessible(true);

        self::assertFalse($method->invoke($kernel));

        /** @noinspection PhpParamsInspection */
        $object = AltrEgo::create($kernel);

        /** @var \StdClass $object */
        $object->id = $id;

        self::assertEquals('/kernels/' . $id, $method->invoke($kernel));
    }
}
