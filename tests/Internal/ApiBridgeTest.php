<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode\Internal;

use Linode\Internal\ApiBridge;

class ApiBridgeTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApiBridge */
    private $api;

    protected function setUp()
    {
        $this->api = new ApiBridge(null, 'https://api.alpha.linode.com/v4');
    }

    public function testPublicGetApi()
    {
        $response = $this->api->call(ApiBridge::METHOD_GET, '/datacenters');

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
     * @expectedExceptionMessage Authorization token required
     */
    public function testAuthorizationError()
    {
        $this->api->call(ApiBridge::METHOD_GET, '/stackscripts/mine');
    }

    /**
     * @expectedException \Linode\LinodeException
     * @expectedExceptionMessage Invalid OAuth token
     */
    public function testInvalidTokenError()
    {
        // sha256('')
        $token  = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';
        $api    = new ApiBridge($token, 'https://api.alpha.linode.com/v4');
        $api->call(ApiBridge::METHOD_GET, '/stackscripts/mine');
    }

    public function testRetrieveErrorsFromSingleMessage()
    {
        $json = '{ "message": "Error description." }';

        $expected = [
            'Error description.',
        ];

        $method = new \ReflectionMethod(ApiBridge::class, 'retrieveErrors');
        $method->setAccessible(true);
        $errors = $method->invokeArgs($this->api, [json_decode($json, true)]);

        self::assertEquals($expected, $errors);
    }

    public function testRetrieveErrorsFromSingleReason()
    {
        $json = '{ "reason": "Error description.", "error": true }';

        $expected = [
            'Error description.',
        ];

        $method = new \ReflectionMethod(ApiBridge::class, 'retrieveErrors');
        $method->setAccessible(true);
        $errors = $method->invokeArgs($this->api, [json_decode($json, true)]);

        self::assertEquals($expected, $errors);
    }

    public function testRetrieveErrorsFromErrorsArray()
    {
        $json = '{ "errors" : [
            { "reason": "Error #1 description.", "field": "Field #1" },
            { "reason": "Error #2 description." },
            { "reason": "Error #3 description.", "field": "Field #2" }
        ] }';

        $expected = [
            'Field #1' => 'Error #1 description.',
            'Error #2 description.',
            'Field #2' => 'Error #3 description.',
        ];

        $method = new \ReflectionMethod(ApiBridge::class, 'retrieveErrors');
        $method->setAccessible(true);
        $errors = $method->invokeArgs($this->api, [json_decode($json, true)]);

        self::assertEquals($expected, $errors);
    }

    public function testRetrieveErrorsFromMessageArray()
    {
        $json = '{ "message" : [
            { "reason": "Error #1 description.", "field": "Field #1" },
            { "reason": "Error #2 description." },
            { "reason": "Error #3 description.", "field": "Field #2" }
        ] }';

        $expected = [
            'Field #1' => 'Error #1 description.',
            'Error #2 description.',
            'Field #2' => 'Error #3 description.',
        ];

        $method = new \ReflectionMethod(ApiBridge::class, 'retrieveErrors');
        $method->setAccessible(true);
        $errors = $method->invokeArgs($this->api, [json_decode($json, true)]);

        self::assertEquals($expected, $errors);
    }

    public function testRetrieveUnknownError()
    {
        $json = '{}';

        $expected = [];

        $method = new \ReflectionMethod(ApiBridge::class, 'retrieveErrors');
        $method->setAccessible(true);
        $errors = $method->invokeArgs($this->api, [json_decode($json, true)]);

        self::assertEquals($expected, $errors);
    }

    public function testGetErrors()
    {
        $json = '[
            { "reason": "Error #1 description.", "field": "Field #1" },
            { "reason": "Error #2 description." },
            { "reason": "Error #3 description.", "field": "Field #2" }
        ]';

        $expected = [
            'Field #1' => 'Error #1 description.',
            'Error #2 description.',
            'Field #2' => 'Error #3 description.',
        ];

        $method = new \ReflectionMethod(ApiBridge::class, 'getErrors');
        $method->setAccessible(true);
        $errors = $method->invokeArgs($this->api, [json_decode($json, true)]);

        self::assertEquals($expected, $errors);
    }
}
