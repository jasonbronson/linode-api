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
            self::OK                   => null,
            self::DELETING             => null,
            self::CREATING             => null,
            self::MIGRATING            => null,
            self::CANCELLING_MIGRATION => null,
            self::DUPLICATING          => null,
            self::RESIZING             => null,
            self::RESTORING            => null,
            self::COPYING              => null,
            self::FREEZING             => null,
            self::THAWING              => null,
        ];
    }
}
