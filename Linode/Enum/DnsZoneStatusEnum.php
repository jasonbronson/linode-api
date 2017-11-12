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
 * DNS zone status.
 */
class DnsZoneStatusEnum extends StaticDictionary
{
    const ACTIVE    = 'active';
    const DISABLED  = 'disabled';
    const EDIT_MODE = 'edit_mode';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::ACTIVE    => null,
            self::DISABLED  => null,
            self::EDIT_MODE => null,
        ];
    }
}
