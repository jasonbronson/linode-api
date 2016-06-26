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
 * Filesystem type.
 */
class FilesystemEnum extends StaticDictionary
{
    const RAW  = 'raw';
    const SWAP = 'swap';
    const EXT3 = 'ext3';
    const EXT4 = 'ext4';

    /**
     * {@inheritdoc}
     */
    public static function all()
    {
        return [
            self::RAW  => 'No filesystem, just a raw binary stream',
            self::SWAP => 'Linux swap area',
            self::EXT3 => 'The ext3 journaling filesystem for Linux',
            self::EXT4 => 'The ext4 journaling filesystem for Linux',
        ];
    }
}
