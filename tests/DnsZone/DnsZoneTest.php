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

use Linode\DnsZone\DnsZone;
use Linode\DnsZone\MasterDnsZone;
use Linode\DnsZone\SlaveDnsZone;
use Linode\LinodeClient;
use Tests\Linode\Internal\ApiBridgeStub;
use Tests\Linode\TestTrait;

class DnsZoneTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(DnsZone::class);

        /** @var DnsZone $dnszone */
        $dnszone = $reflectionClass->newInstanceWithoutConstructor();
        self::assertEquals('/dnszones', $dnszone->getEndpoint());

        $this->setProtectedProperty($dnszone, 'id', $id);
        self::assertEquals('/dnszones/' . $id, $dnszone->getEndpoint());
    }

    public function testGetInstance()
    {
        $expected = [
            MasterDnsZone::class,
            SlaveDnsZone::class,
            SlaveDnsZone::class,
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $this->setProtectedProperty($client, 'api', new ApiBridgeStub());

        $dnszones = $client->getDnsZones();

        $actual = [];

        foreach ($dnszones as $dnszone) {
            $actual[] = get_class($dnszone);
        }

        self::assertEquals($expected, $actual);
    }
}
