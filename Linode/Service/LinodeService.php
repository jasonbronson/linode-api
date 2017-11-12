<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Service;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A Linode service.
 *
 * @property    string  $ram        Amount of RAM included in this service.
 * @property    string  $vcpus      If applicable, number of CPU cores.
 * @property    string  $disk       If applicable, disk space in MB.
 * @property    string  $transfer   If applicable, outbound transfer in MB.
 * @property    string  $mbits_out  If applicable, Mbits outbound bandwidth.
 */
class LinodeService extends Service
{
    protected $ram;
    protected $vcpus;
    protected $disk;
    protected $transfer;
    protected $mbits_out;

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

        $metadata->addPropertyConstraints('vcpus', [
            new Constraints\Type(['type' => 'int']),
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

        $metadata->addPropertyConstraints('mbits_out', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);
    }
}
