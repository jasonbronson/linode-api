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

use Linode\Enum\DiskStateEnum;

class DiskStateEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testKeys()
    {
        $expected = [
            'ok',
            'deleting',
            'creating',
            'migrating',
            'cancelling-migration',
            'duplicating',
            'resizing',
            'restoring',
            'copying',
            'freezing',
            'thawing',
        ];

        self::assertEquals($expected, DiskStateEnum::keys());
    }
}
