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
            self::ACTIVE    => 'Turn on serving of this DNS Zone',
            self::DISABLED  => 'Turn off serving of this DNS Zone',
            self::EDIT_MODE => 'Use this mode while making edits',
        ];
    }
}
