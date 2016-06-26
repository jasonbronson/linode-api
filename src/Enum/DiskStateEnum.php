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
 * A disk image state.
 */
class DiskStateEnum extends StaticDictionary
{
    const OK                   = 'ok';
    const DELETING             = 'deleting';
    const CREATING             = 'creating';
    const MIGRATING            = 'migrating';
    const CANCELLING_MIGRATION = 'cancelling-migration';
    const DUPLICATING          = 'duplicating';
    const RESIZING             = 'resizing';
    const RESTORING            = 'restoring';
    const COPYING              = 'copying';
    const FREEZING             = 'freezing';
    const THAWING              = 'thawing';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::OK                   => 'No disk jobs are running',
            self::DELETING             => 'This disk is being deleted',
            self::CREATING             => 'This disk is being created',
            self::MIGRATING            => 'This disk is being migrated',
            self::CANCELLING_MIGRATION => 'The disk migration is being cancelled',
            self::DUPLICATING          => 'This disk is being duplicated',
            self::RESIZING             => 'This disk is being resized',
            self::RESTORING            => 'This disk is being restored',
            self::COPYING              => 'This disk is being copied',
            self::FREEZING             => 'This disk is being frozen',
            self::THAWING              => 'This disk is being thawed',
        ];
    }
}
