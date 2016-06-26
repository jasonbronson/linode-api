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

use Linode\Enum\BackupStatusEnum;

class BackupStatusEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testKeys()
    {
        $expected = [
            'pending',
            'running',
            'needsPostProcessing',
            'successful',
            'failed',
            'userAborted',
        ];

        self::assertEquals($expected, BackupStatusEnum::keys());
    }
}
