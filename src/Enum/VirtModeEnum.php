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
 * Virtualization mode.
 */
class VirtModeEnum extends StaticDictionary
{
    const FULLVIRT = 'fullvirt';
    const PARAVIRT = 'paravirt';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::FULLVIRT => null,
            self::PARAVIRT => null,
        ];
    }
}
