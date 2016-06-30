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
 * Status of a backup.
 */
class BackupStatusEnum extends StaticDictionary
{
    const PENDING             = 'pending';
    const RUNNING             = 'running';
    const NEEDSPOSTPROCESSING = 'needsPostProcessing';
    const SUCCESSFUL          = 'successful';
    const FAILED              = 'failed';
    const USERABORTED         = 'userAborted';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::PENDING             => null,
            self::RUNNING             => null,
            self::NEEDSPOSTPROCESSING => null,
            self::SUCCESSFUL          => null,
            self::FAILED              => null,
            self::USERABORTED         => null,
        ];
    }
}
