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
 * A Linode datacenter.
 */
class DatacenterEnum extends StaticDictionary
{
    const DALLAS    = 'dallas';
    const FREMONT   = 'fremont';
    const ATLANTA   = 'atlanta';
    const NEWARK    = 'newark';
    const LONDON    = 'london';
    const TOKYO     = 'tokyo';
    const SINGAPORE = 'singapore';
    const FRANKFURT = 'frankfurt';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::DALLAS    => 'Dallas, TX',
            self::FREMONT   => 'Fremont, CA',
            self::ATLANTA   => 'Atlanta, GA',
            self::NEWARK    => 'Newark, NJ',
            self::LONDON    => 'London, UK',
            self::TOKYO     => 'Tokyo, JP',
            self::SINGAPORE => 'Singapore, SG',
            self::FRANKFURT => 'Frankfurt, DE',
        ];
    }
}
