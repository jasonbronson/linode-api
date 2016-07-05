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
use Linode\Enum\DnsZoneStatusEnum;
use Linode\LinodeClient;
use Tests\Linode\TestTrait;

class MasterDnsZoneTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testConstructor()
    {
        $client  = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $dnszone = new MasterDnsZone($client, 'example.com', 'admin@example.com');

        self::assertEquals('example.com', $dnszone->dnszone);
        self::assertEquals('admin@example.com', $dnszone->soa_email);
    }

    public function testGetMutableProperties()
    {
        $expected = [
            'status'        => DnsZoneStatusEnum::ACTIVE,
            'dnszone'       => 'example.com',
            'description'   => null,
            'display_group' => null,
            'axfr_ips'      => [],
            'soa_email'     => 'admin@example.com',
            'ttl_sec'       => null,
            'refresh_sec'   => null,
            'retry_sec'     => null,
            'expire_sec'    => null,
        ];

        $client  = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $dnszone = new MasterDnsZone($client, 'example.com', 'admin@example.com');

        self::assertEquals($expected, $this->callMethod($dnszone, 'getMutableProperties'));
    }
}
