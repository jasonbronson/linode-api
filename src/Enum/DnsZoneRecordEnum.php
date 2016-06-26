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
            self::A     => 'Address Mapping Record',
            self::AAAA  => 'IP Version 6 Address Record',
            self::NS    => 'Name Server Record',
            self::MX    => 'Mail Exchanger Record',
            self::CNAME => 'Canonical Name Record',
            self::TXT   => 'Text Record',
            self::SRV   => 'Service Record',
        ];
    }
}
