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
use Linode\BackupService;
use Linode\LinodeService;
use Linode\LongviewService;
use Linode\NodeBalancerService;

/**
 * Service type.
 */
class ServiceTypeEnum extends StaticDictionary
{
    const LINODE       = 'linode';
    const BACKUP       = 'backup';
    const NODEBALANCER = 'nodebalancer';
    const LONGVIEW     = 'longview';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::LINODE       => LinodeService::class,
            self::BACKUP       => BackupService::class,
            self::NODEBALANCER => NodeBalancerService::class,
            self::LONGVIEW     => LongviewService::class,
        ];
    }
}
