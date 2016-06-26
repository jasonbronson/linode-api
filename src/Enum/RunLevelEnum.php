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
 * Run level for Linode boot.
 */
class RunLevelEnum extends StaticDictionary
{
    const NORMAL  = 'default';
    const SINGLE  = 'single';
    const BINBASH = 'binbash';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::NORMAL  => 'Normal multi-user boot mode',
            self::SINGLE  => 'Single user boot mode',
            self::BINBASH => 'Boots to a root bash shell',
        ];
    }
}
