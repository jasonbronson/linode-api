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

use Linode\Collection;
use Linode\Distribution;
use Linode\LinodeClient;
use Tests\Linode\Internal\ApiBridgeStub;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    /** @var LinodeClient */
    private $client;

    protected function setUp()
    {
        $this->client = new LinodeClient(null, 'https://api.alpha.linode.com/v4');

        $this->setProtectedProperty($this->client, 'api', new ApiBridgeStub());
    }

    public function testIterator()
    {
        $expected = [
            'CentOS 5.6',
            'Debian 6',
            'Slackware 13.37 32bit',
            'Slackware 13.37',
            'Slackware 14.1',
            'Gentoo 2013-11-26',
            'openSUSE 13.1',
            'Fedora 20',
            'Ubuntu 12.04 LTS',
            'CentOS 6.5',
            'CentOS 7',
            'Debian 7',
            'Fedora 21',
            'openSUSE 13.2',
            'Gentoo 2014.12',
            'Arch Linux 2015.02',
            'Ubuntu 15.04',
            'Debian 8.1',
            'Fedora 22',
            'Arch Linux 2015.08',
            'Ubuntu 15.10',
        ];

        /** @var Distribution[] $collection */
        $collection = new Collection($this->client, '/distributions', Distribution::class, 'distributions');

        self::assertCount(count($expected), $collection);

        foreach ($collection as $key => $item) {
            self::assertInstanceOf(Distribution::class, $item);
            self::assertEquals($expected[$key], $item->label);
        }
    }
}
