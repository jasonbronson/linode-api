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

use Linode\DnsZoneRecord\CnameRecord;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class CnameRecordTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new CnameRecord($client, 'dnszone_1', 'ghs.google.com', 'mail');

        self::assertEquals('ghs.google.com', $record->hostname);
        self::assertEquals('mail', $record->alias);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'ttl_sec' => null,
            'name'    => 'ghs.google.com',
            'target'  => 'mail',
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $record = new CnameRecord($client, 'dnszone_1', 'ghs.google.com', 'mail');

        self::assertEquals($expected, $this->callMethod($record, 'getMutableProperties'));
    }
}
