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
 * Slave DNS Zone.
 *
 * @property    string[]  $master_ips  An array of IP addresses for this DNS Zone.
 */
class SlaveDnsZone extends DnsZone
{
    protected $master_ips;

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraints('master_ips', [
            new Constraints\Type(['type' => 'array']),
            new Constraints\NotNull(),
            new Constraints\Count(['min' => 0, 'max' => 6]),
            new Constraints\All([
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Constraints\Ip(['version' => '4']),
                ],
            ]),
        ]);
    }
}
