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
            self::PENDING             => 'Backup is in the queue and waiting to begin',
            self::RUNNING             => 'Linode in the process of being backed up',
            self::NEEDSPOSTPROCESSING => 'Backups awaiting final integration into existing backup data',
            self::SUCCESSFUL          => 'Backup successfully completed',
            self::FAILED              => 'Linode backup failed',
            self::USERABORTED         => 'User aborted current backup process',
        ];
    }
}
