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

use Linode\DnsZone\MasterDnsZone;
use Linode\DnsZone\SlaveDnsZone;
use Linode\DnsZoneRecord\DnsZoneRecord;
use Linode\Enum\DnsZoneRecordEnum;
use Linode\LinodeClient;
use Tests\Linode\Internal\ApiBridgeStub;
use Tests\Linode\TestTrait;

class DnsZoneTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    /** @var LinodeClient */
    private $client;

    protected function setUp()
    {
        $this->client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $this->setProperty($this->client, 'api', new ApiBridgeStub());
    }

    public function testGetRecords()
    {
        $dnszone = $this->client->getDnsZone('dnszone_1');

        $collection = $dnszone->getRecords();

        self::assertCount(15, $collection);
    }

    public function testGetRecord()
    {
        $dnszone = $this->client->getDnsZone('dnszone_1');

        $object = $dnszone->getRecord('dnsrecord_1');

        self::assertInstanceOf(DnsZoneRecord::class, $object);
        self::assertEquals(DnsZoneRecordEnum::NS, $object->type);
    }

    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(MasterDnsZone::class);

        /** @var MasterDnsZone $dnszone */
        $dnszone = $reflectionClass->newInstanceWithoutConstructor();
        self::assertEquals('/dnszones', $dnszone->getEndpoint());

        $this->setProperty($dnszone, 'id', $id);
        self::assertEquals('/dnszones/' . $id, $dnszone->getEndpoint());
    }

    public function testGetInstance()
    {
        $expected = [
            MasterDnsZone::class,
            SlaveDnsZone::class,
            SlaveDnsZone::class,
        ];

        $dnszones = $this->client->getDnsZones();

        $actual = [];

        foreach ($dnszones as $dnszone) {
            $actual[] = get_class($dnszone);
        }

        self::assertEquals($expected, $actual);
    }
}
