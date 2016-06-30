<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A backup service.
 *
 * @property    string  $ram       Amount of RAM included in this service.
 * @property    string  $disk      If applicable, disk space in MB.
 * @property    string  $transfer  If applicable, outbound transfer in MB.
 */
class BackupService extends Service
{
    protected $ram;
    protected $disk;
    protected $transfer;

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraints('ram', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('disk', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('transfer', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);
    }
}
