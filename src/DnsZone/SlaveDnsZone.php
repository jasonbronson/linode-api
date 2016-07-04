<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\DnsZone;

use Linode\Enum\DnsZoneStatusEnum;
use Linode\Enum\DnsZoneTypeEnum;
use Linode\LinodeClient;
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
     * Creates new slave zone.
     *
     * @param   LinodeClient $client     Linode API client.
     * @param   string       $dnszone    The DNS Zone name.
     * @param   string[]     $master_ips An array of IP addresses for this DNS Zone.
     *
     * @throws  \Linode\ValidationException
     */
    public function __construct(LinodeClient $client, $dnszone, array $master_ips = [])
    {
        parent::__construct($client, null, [
            'type'       => DnsZoneTypeEnum::SLAVE,
            'status'     => DnsZoneStatusEnum::ACTIVE,
            'dnszone'    => $dnszone,
            'master_ips' => $master_ips,
            'axfr_ips'   => [],
        ]);
    }

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
