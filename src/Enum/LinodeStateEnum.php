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
            self::OFFLINE       => 'The Linode is powered off',
            self::BOOTING       => 'The Linode is currently booting up',
            self::RUNNING       => 'The Linode is currently running',
            self::SHUTTING_DOWN => 'The Linode is currently shutting down',
            self::REBOOTING     => 'The Linode is rebooting',
            self::PROVISIONING  => 'The Linode is being created',
            self::DELETING      => 'The Linode is being deleted',
            self::MIGRATING     => 'The Linode is being migrated to a new host/datacenter',
        ];
    }
}
