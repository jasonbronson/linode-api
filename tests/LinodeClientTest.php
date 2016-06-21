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

    public function testPublicGetApi()
    {
        $response = $this->client->apiGet('/datacenters');

        self::assertArrayHasKey('page', $response);
        self::assertArrayHasKey('total_pages', $response);
        self::assertArrayHasKey('total_results', $response);
        self::assertArrayHasKey('datacenters', $response);

        self::assertEquals(1, $response['page']);
        self::assertEquals(1, $response['total_pages']);
        self::assertCount($response['total_results'], $response['datacenters']);
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

    /**
     * @expectedException \Linode\LinodeException
     * @expectedExceptionMessage Authorization token required
     */
    public function testAuthorizationError()
    {
        $this->client->apiGet('/stackscripts/mine');
    }

    /**
     * @expectedException \Linode\LinodeException
     * @expectedExceptionMessage Invalid OAuth token
     */
    public function testInvalidTokenError()
    {
        // sha256('')
        $token  = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';
        $client = new LinodeClient($token, 'https://api.alpha.linode.com/v4');
        $client->apiGet('/stackscripts/mine');
    }
}
