<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode\DnsZone;

use Linode\DnsZoneRecord\A4Record;
use Linode\DnsZoneRecord\A6Record;
use Linode\DnsZoneRecord\CnameRecord;
use Linode\DnsZoneRecord\MxRecord;
use Linode\DnsZoneRecord\NsRecord;
use Linode\DnsZoneRecord\SrvRecord;
use Linode\DnsZoneRecord\TxtRecord;
use Linode\LinodeClient;
use Tests\Linode\Internal\ApiBridgeStub;
use Tests\Linode\TestTrait;

class DnsZoneRecordTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testGetEndpoint()
    {
        $id     = mt_rand();
        $parent = mt_rand();

        $reflectionClass = new \ReflectionClass(CnameRecord::class);

        /** @var CnameRecord $record */
        $record = $reflectionClass->newInstanceWithoutConstructor();
        $this->setProperty($record, 'parent', $parent);
        self::assertEquals('/dnszones/' . $parent . '/records', $record->getEndpoint());

        $this->setProperty($record, 'id', $id);
        self::assertEquals('/dnszones/' . $parent . '/records/' . $id, $record->getEndpoint());
    }

    public function testGetInstance()
    {
        $expected = [
            NsRecord::class,
            NsRecord::class,
            NsRecord::class,
            A4Record::class,
            A4Record::class,
            A6Record::class,
            CnameRecord::class,
            MxRecord::class,
            MxRecord::class,
            MxRecord::class,
            MxRecord::class,
            MxRecord::class,
            TxtRecord::class,
            TxtRecord::class,
            SrvRecord::class,
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $this->setProperty($client, 'api', new ApiBridgeStub());

        $records = $client->getDnsZone('dnszone_1')->getRecords();

        $actual = [];

        foreach ($records as $record) {
            $actual[] = get_class($record);
        }

        self::assertEquals($expected, $actual);
    }
}
