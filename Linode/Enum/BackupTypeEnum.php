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
 * Type of a backup.
 */
class BackupTypeEnum extends StaticDictionary
{
    const AUTO     = 'auto';
    const SNAPSHOT = 'snapshot';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::AUTO     => null,
            self::SNAPSHOT => null,
        ];
    }
}
