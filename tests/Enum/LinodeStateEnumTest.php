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

use Linode\Enum\LinodeStateEnum;

class LinodeStateEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testKeys()
    {
        $expected = [
            'offline',
            'booting',
            'running',
            'shutting_down',
            'rebooting',
            'provisioning',
            'deleting',
            'migrating',
        ];

        self::assertEquals($expected, LinodeStateEnum::keys());
    }
}
