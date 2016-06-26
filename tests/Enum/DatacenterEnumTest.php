<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode\Enum;

use Linode\Enum\DatacenterEnum;

class DatacenterEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testKeys()
    {
        $expected = [
            'dallas',
            'fremont',
            'atlanta',
            'newark',
            'london',
            'tokyo',
            'singapore',
            'frankfurt',
        ];

        self::assertEquals($expected, DatacenterEnum::keys());
    }
}
