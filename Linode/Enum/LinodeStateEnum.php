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
 * State of a Linode.
 */
class LinodeStateEnum extends StaticDictionary
{
    const OFFLINE       = 'offline';
    const BOOTING       = 'booting';
    const RUNNING       = 'running';
    const SHUTTING_DOWN = 'shutting_down';
    const REBOOTING     = 'rebooting';
    const PROVISIONING  = 'provisioning';
    const DELETING      = 'deleting';
    const MIGRATING     = 'migrating';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::OFFLINE       => null,
            self::BOOTING       => null,
            self::RUNNING       => null,
            self::SHUTTING_DOWN => null,
            self::REBOOTING     => null,
            self::PROVISIONING  => null,
            self::DELETING      => null,
            self::MIGRATING     => null,
        ];
    }
}
