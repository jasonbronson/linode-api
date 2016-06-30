<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode;

use Linode\LinodeClient;
use Linode\MasterDnsZone;

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
}
