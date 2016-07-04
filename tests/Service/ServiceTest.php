<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode\Service;

use Linode\LinodeClient;
use Linode\Service\BackupService;
use Linode\Service\LinodeService;
use Linode\Service\LongviewService;
use Linode\Service\Service;
use Tests\Linode\Internal\ApiBridgeStub;
use Tests\Linode\TestTrait;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testGetEndpoint()
    {
        $id = mt_rand();

        $reflectionClass = new \ReflectionClass(Service::class);

        /** @var Service $service */
        $service = $reflectionClass->newInstanceWithoutConstructor();
        self::assertEquals('/services', $service->getEndpoint());

        $this->setProtectedProperty($service, 'id', $id);
        self::assertEquals('/services/' . $id, $service->getEndpoint());
    }

    public function testGetInstance()
    {
        $expected = [
            LongviewService::class,
            LongviewService::class,
            LongviewService::class,
            LongviewService::class,
            LinodeService::class,
            LinodeService::class,
            BackupService::class,
        ];

        $client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');
        $this->setProtectedProperty($client, 'api', new ApiBridgeStub());

        $services = $client->getServices();

        $actual = [];

        foreach ($services as $service) {
            $actual[] = get_class($service);
        }

        self::assertEquals($expected, $actual);
    }
}
