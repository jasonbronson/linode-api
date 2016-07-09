<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\DnsZoneRecord;

use Linode\Enum\DnsZoneRecordEnum;
use Linode\LinodeClient;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * SRV-record.
 *
 * @property    string  $service   The service to append to the record.
 * @property    string  $protocol  The protocol to append to the record.
 * @property    int     $port      The TCP or UDP port on which the service is to be found.
 * @property    int     $priority  Priority of the record.
 * @property    int     $weight    A relative weight for records with the same priority, higher value means more preferred.
 * @property    string  $target    Optional subdomain of the service.
 */
class SrvRecord extends DnsZoneRecord
{
    protected $service;
    protected $protocol;
    protected $port;
    protected $priority;
    protected $weight;
    protected $target;

    /**
     * Creates new record.
     *
     * @param   LinodeClient $client    Linode API client.
     * @param   string       $dnszone   DNS Zone ID which this record belongs to.
     * @param   string       $service   The service to append to the record.
     * @param   string       $protocol  The protocol to append to the record.
     * @param   int          $port      The TCP or UDP port on which the service is to be found.
     * @param   int          $priority  Priority of the record.
     * @param   int          $weight    A relative weight for records with the same priority, higher value means more preferred.
     * @param   string       $target    Optional subdomain of the service.
     *
     * @throws  \Linode\ValidationException
     */
    public function __construct(LinodeClient $client, $dnszone, $service, $protocol, $port, $priority = 10, $weight = 5, $target = null)
    {
        parent::__construct($client, [
            'type'     => DnsZoneRecordEnum::SRV,
            'service'  => $service,
            'protocol' => $protocol,
            'port'     => $port,
            'priority' => $priority,
            'weight'   => $weight,
            'target'   => $target,
        ], $dnszone);
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('service', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Length(['max' => 100]),
        ]);

        $metadata->addPropertyConstraints('protocol', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Choice(['choices' => ['_tcp', '_udp', '_xmpp', '_tls']]),
        ]);

        $metadata->addPropertyConstraints('port', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\Range(['min' => 1, 'max' => 65535]),
        ]);

        $metadata->addPropertyConstraints('priority', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\Range(['min' => 0, 'max' => 255]),
        ]);

        $metadata->addPropertyConstraints('weight', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\Range(['min' => 0, 'max' => 255]),
        ]);

        $metadata->addPropertyConstraints('target', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\Length(['max' => 100]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMutableProperties()
    {
        $properties = parent::getMutableProperties();

        $properties['service']  = $this->service;
        $properties['protocol'] = $this->protocol;
        $properties['port']     = $this->port;
        $properties['priority'] = $this->priority;
        $properties['weight']   = $this->weight;
        $properties['target']   = $this->target;

        return $properties;
    }
}
