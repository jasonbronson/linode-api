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
use Linode\DnsZoneRecord;

/**
 * DNS zone record type.
 */
class DnsZoneRecordEnum extends StaticDictionary
{
    const A     = 'A';
    const AAAA  = 'AAAA';
    const NS    = 'NS';
    const MX    = 'MX';
    const CNAME = 'CNAME';
    const TXT   = 'TXT';
    const SRV   = 'SRV';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::A     => DnsZoneRecord\A4Record::class,
            self::AAAA  => DnsZoneRecord\A6Record::class,
            self::NS    => DnsZoneRecord\NsRecord::class,
            self::MX    => DnsZoneRecord\MxRecord::class,
            self::CNAME => DnsZoneRecord\CnameRecord::class,
            self::TXT   => DnsZoneRecord\TxtRecord::class,
            self::SRV   => DnsZoneRecord\SrvRecord::class,
        ];
    }
}
