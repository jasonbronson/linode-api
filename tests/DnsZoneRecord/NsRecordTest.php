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

use Linode\DnsZoneRecord\NsRecord;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class NsRecordTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new NsRecord($client, 'dnszone_1', '8.8.8.8');

        self::assertEquals('8.8.8.8', $record->nameserver);
        self::assertNull($record->subdomain);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'ttl_sec' => null,
            'name'    => '8.8.8.8',
            'target'  => 'sub',
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new NsRecord($client, 'dnszone_1', '8.8.8.8', 'sub');

        self::assertEquals($expected, $this->callMethod($record, 'getMutableProperties'));
    }
}
