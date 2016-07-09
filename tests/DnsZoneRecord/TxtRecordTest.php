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

use Linode\DnsZoneRecord\TxtRecord;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class TxtRecordTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new TxtRecord($client, 'dnszone_1');

        self::assertNull($record->name);
        self::assertNull($record->value);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'ttl_sec' => null,
            'name'    => 'google._domainkey',
            'target'  => 'v=DKIM1; k=rsa;',
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new TxtRecord($client, 'dnszone_1', 'google._domainkey', 'v=DKIM1; k=rsa;');

        self::assertEquals($expected, $this->callMethod($record, 'getMutableProperties'));
    }
}
