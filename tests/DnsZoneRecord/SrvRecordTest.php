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

use Linode\DnsZoneRecord\SrvRecord;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class SrvRecordTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new SrvRecord($client, 'dnszone_1', '_sip', '_tcp', 80);

        self::assertEquals('_sip', $record->service);
        self::assertEquals('_tcp', $record->protocol);
        self::assertEquals(80, $record->port);
        self::assertEquals(10, $record->priority);
        self::assertEquals(5, $record->weight);
        self::assertNull($record->target);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'ttl_sec'  => null,
            'service'  => '_sip',
            'protocol' => '_tcp',
            'port'     => 443,
            'priority' => 5,
            'weight'   => 1,
            'target'   => 'sub',
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new SrvRecord($client, 'dnszone_1', '_sip', '_tcp', 443, 5, 1, 'sub');

        self::assertEquals($expected, $this->callMethod($record, 'getMutableProperties'));
    }
}
