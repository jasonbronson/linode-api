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
 * A-record.
 *
 * @property    string  $ip_address  Target IPv4 address.
 * @property    string  $hostname    FQDN or subdomain.
 */
class A4Record extends DnsZoneRecord
{
    protected $ip_address;
    protected $hostname;

    /**
     * Creates new record.
     *
     * @param   LinodeClient $client     Linode API client.
     * @param   string       $dnszone    DNS Zone ID which this record belongs to.
     * @param   string       $ip_address Target IPv4 address.
     * @param   string       $hostname   FQDN or subdomain.
     *
     * @throws  \Linode\ValidationException
     */
    public function __construct(LinodeClient $client, $dnszone, $ip_address, $hostname = null)
    {
        parent::__construct($client, [
            'type'   => DnsZoneRecordEnum::A,
            'target' => $ip_address,
            'name'   => $hostname,
        ], $dnszone);
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('ip_address', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Ip(['version' => 4]),
        ]);
        $metadata->addPropertyConstraints('hostname', [
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

        $properties['target'] = $this->ip_address;
        $properties['name']   = $this->hostname;

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(array $data = [])
    {
        $properties = [
            'target' => 'ip_address',
            'name'   => 'hostname',
        ];

        foreach ($properties as $key => $property) {
            if (array_key_exists($key, $data)) {
                $this->$property = $data[$key];
            }
        }

        parent::initialize($data);
    }
}
