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

use Linode\Internal\AbstractImmutableObject;
use Linode\Internal\ValidatedObjectInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A service available for purchase from Linode.
 *
 * @property    string  $id             A string.
 * @property    string  $service_type   The type of service offered.
 * @property    string  $label          Human-friendly name of this service.
 * @property    string  $hourly_price   Cost (in cents) per hour.
 * @property    string  $monthly_price  Cost (in cents) per month.
 * @property    string  $ram            Amount of RAM included in this service.
 * @property    string  $vcpus          If applicable, number of CPU cores.
 * @property    string  $disk           If applicable, disk space in MB.
 * @property    string  $transfer       If applicable, outbound transfer in MB.
 * @property    string  $mbits_out      If applicable, Mbits outbound bandwidth.
 */
class Service extends AbstractImmutableObject implements ValidatedObjectInterface
{
    protected $id;
    protected $service_type;
    protected $label;
    protected $hourly_price;
    protected $monthly_price;
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
        $metadata->addPropertyConstraints('id', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('service_type', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Choice(['callback' => ['Linode\Enum\ServiceTypeEnum', 'keys']]),
        ]);

        $metadata->addPropertyConstraints('label', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('hourly_price', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('monthly_price', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

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

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return $this->id === null ? false : '/services/' . $this->id;
    }
}
