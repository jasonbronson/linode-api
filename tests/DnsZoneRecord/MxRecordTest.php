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

use Linode\DnsZoneRecord\MxRecord;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class MxRecordTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new MxRecord($client, 'dnszone_1', 'aspmx.l.google.com');

        self::assertEquals('aspmx.l.google.com', $record->mail_server);
        self::assertNull($record->subdomain);
        self::assertEquals(10, $record->priority);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'ttl_sec'  => null,
            'target'   => 'aspmx.l.google.com',
            'name'     => 'mail',
            'priority' => 5,
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new MxRecord($client, 'dnszone_1', 'aspmx.l.google.com', 'mail', 5);

        self::assertEquals($expected, $this->callMethod($record, 'getMutableProperties'));
    }
}
