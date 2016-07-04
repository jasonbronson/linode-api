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
use Linode\Service;

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
            self::LINODE       => Service\LinodeService::class,
            self::BACKUP       => Service\BackupService::class,
            self::NODEBALANCER => Service\NodeBalancerService::class,
            self::LONGVIEW     => Service\LongviewService::class,
        ];
    }
}
