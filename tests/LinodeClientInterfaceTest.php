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

use AltrEgo\AltrEgo;
use Linode\Datacenter;
use Linode\Distribution;
use Linode\Kernel;
use Linode\LinodeClient;
use Tests\Linode\Internal\ApiBridgeStub;

class LinodeClientInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /** @var LinodeClient */
    private $client;

    protected function setUp()
    {
        $this->client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');

        /** @noinspection PhpParamsInspection */
        $client = AltrEgo::create($this->client);

        /** @var \StdClass $client */
        $client->api = new ApiBridgeStub();
    }

    public function testGetDatacenters()
    {
        $collection = $this->client->getDatacenters();

        self::assertCount(8, $collection);
    }

    public function testFindDatacenter()
    {
        $object = $this->client->findDatacenter('datacenter_6');

        self::assertInstanceOf(Datacenter::class, $object);
        self::assertEquals('Newark, NJ', $object->label);
    }

    public function testGetDistributions()
    {
        $collection = $this->client->getDistributions(false);

        self::assertCount(21, $collection);
    }

    public function testGetRecommendedDistributions()
    {
        $collection = $this->client->getDistributions(true);

        self::assertCount(9, $collection);
    }

    public function testFindDistribution()
    {
        $object = $this->client->findDistribution('distribution_126');

        self::assertInstanceOf(Distribution::class, $object);
        self::assertEquals('Ubuntu 12.04 LTS', $object->label);
    }

    public function testGetKernels()
    {
        $collection = $this->client->getKernels();

        self::assertCount(16, $collection);
    }

    public function testFindKernel()
    {
        $object = $this->client->findKernel('kernel_137');

        self::assertInstanceOf(Kernel::class, $object);
        self::assertEquals('Latest 32 bit (4.1.5-x86-linode80)', $object->label);
    }
}
