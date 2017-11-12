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
 * A Linode datacenter.
 *
 * @property    string  $datacenter  Datacenter alias (@see "Linode\Enum\DatacenterEnum").
 * @property    string  $label       Human-friendly datacenter name.
 */
class Datacenter extends Internal\AbstractImmutableObject
{
    protected $datacenter;
    protected $label;

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return rtrim('/datacenters/' . $this->id, '/');
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('datacenter', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Choice(['callback' => ['Linode\Enum\DatacenterEnum', 'keys']]),
        ]);

        $metadata->addPropertyConstraints('label', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);
    }
}
