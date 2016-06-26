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

use Linode\Enum\DnsZoneRecordEnum;

class DnsZoneRecordEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testKeys()
    {
        $expected = [
            'A',
            'AAAA',
            'NS',
            'MX',
            'CNAME',
            'TXT',
            'SRV',
        ];

        self::assertEquals($expected, DnsZoneRecordEnum::keys());
    }
}
