<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode\DnsZoneRecord;

use Linode\DnsZoneRecord\A6Record;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class A6RecordTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new A6Record($client, 'dnszone_1', '0:0:0:0:0:ffff:c0a8:1');

        self::assertEquals('0:0:0:0:0:ffff:c0a8:1', $record->ip_address);
        self::assertNull($record->hostname);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'ttl_sec' => null,
            'target'  => '0:0:0:0:0:ffff:c0a8:1',
            'name'    => 'admin',
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new A6Record($client, 'dnszone_1', '0:0:0:0:0:ffff:c0a8:1', 'admin');

        self::assertEquals($expected, $this->callMethod($record, 'getMutableProperties'));
    }
}
