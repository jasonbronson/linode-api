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

use Linode\DnsZone\SlaveDnsZone;
use Linode\Enum\DnsZoneStatusEnum;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class SlaveDnsZoneTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client  = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $dnszone = new SlaveDnsZone($client, 'example.com', ['127.0.0.1']);

        self::assertEquals('example.com', $dnszone->dnszone);
        self::assertEquals(['127.0.0.1'], $dnszone->master_ips);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'status'        => DnsZoneStatusEnum::ACTIVE,
            'dnszone'       => 'example.com',
            'description'   => null,
            'display_group' => null,
            'axfr_ips'      => [],
            'master_ips'    => ['127.0.0.1'],
        ];

        $client  = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $dnszone = new SlaveDnsZone($client, 'example.com', ['127.0.0.1']);

        self::assertEquals($expected, $this->callMethod($dnszone, 'getMutableProperties'));
    }
}
