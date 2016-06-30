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

use Linode\Kernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(Kernel::class);

        /** @var Kernel $kernel */
        $kernel = $reflectionClass->newInstanceWithoutConstructor();
        self::assertEquals('/kernels', $kernel->getEndpoint());

        $this->setProtectedProperty($kernel, 'id', $id);
        self::assertEquals('/kernels/' . $id, $kernel->getEndpoint());
    }
}
