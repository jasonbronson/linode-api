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
use Linode\Distribution;

class DistributionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(Distribution::class);

        /** @var Distribution $distribution */
        $distribution = $reflectionClass->newInstanceWithoutConstructor();

        self::assertEquals('/distributions', $distribution->getEndpoint());

        /** @noinspection PhpParamsInspection */
        $object = AltrEgo::create($distribution);

        /** @var \StdClass $object */
        $object->id = $id;

        self::assertEquals('/distributions/' . $id, $distribution->getEndpoint());
    }
}
