<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Enum;

use Dictionary\StaticDictionary;
use Linode\MasterDnsZone;
use Linode\SlaveDnsZone;

/**
 * DNS zone type.
 */
class DnsZoneTypeEnum extends StaticDictionary
{
    const MASTER = 'master';
    const SLAVE  = 'slave';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::MASTER => MasterDnsZone::class,
            self::SLAVE  => SlaveDnsZone::class,
        ];
    }
}
