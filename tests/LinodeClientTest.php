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

class LinodeClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var LinodeClient */
    private $client;

    protected function setUp()
    {
        $this->client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
    }

    /**
     * @expectedException \Linode\LinodeException
     * @expectedExceptionMessage Not found
     */
    public function testNotFoundError()
    {
        $this->client->apiGet('/datacenters/datacenter_0');
    }

    /**
     * @expectedException \Linode\LinodeException
     */
    public function testPostNotAllowedError()
    {
        $this->client->apiPost('/datacenters');
    }

    /**
     * @expectedException \Linode\LinodeException
     * @expectedExceptionMessage The method is not allowed for the requested URL.
     */
    public function testPutNotAllowedError()
    {
        $this->client->apiPut('/datacenters/datacenter_0', [
            'label' => 'Auckland, NZ',
        ]);
    }

    /**
     * @expectedException \Linode\LinodeException
     * @expectedExceptionMessage The method is not allowed for the requested URL.
     */
    public function testDeleteNotAllowedError()
    {
        $this->client->apiDelete('/datacenters/datacenter_0');
    }
}
