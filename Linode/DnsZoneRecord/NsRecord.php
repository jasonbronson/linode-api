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
 * NS-record.
 *
 * @property    string  $nameserver  FQDN of the nameserver.
 * @property    string  $subdomain   Optional subdomain to be delegated to the nameserver.
 */
class NsRecord extends DnsZoneRecord
{
    protected $nameserver;
    protected $subdomain;

    /**
     * Creates new record.
     *
     * @param   LinodeClient $client     Linode API client.
     * @param   string       $dnszone    DNS Zone ID which this record belongs to.
     * @param   string       $nameserver FQDN of the nameserver.
     * @param   string       $subdomain  Optional subdomain to be delegated to the nameserver.
     *
     * @throws  \Linode\ValidationException
     */
    public function __construct(LinodeClient $client, $dnszone, $nameserver, $subdomain = null)
    {
        parent::__construct($client, [
            'type'   => DnsZoneRecordEnum::NS,
            'name'   => $nameserver,
            'target' => $subdomain,
        ], $dnszone);
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('nameserver', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Length(['max' => 100]),
        ]);

        $metadata->addPropertyConstraints('subdomain', [
            new Constraints\Type(['type' => 'string']),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMutableProperties()
    {
        $properties = parent::getMutableProperties();

        $properties['name']   = $this->nameserver;
        $properties['target'] = $this->subdomain;

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(array $data = [])
    {
        $properties = [
            'name'   => 'nameserver',
            'target' => 'subdomain',
        ];

        foreach ($properties as $key => $property) {
            if (array_key_exists($key, $data)) {
                $this->$property = $data[$key];
            }
        }

        parent::initialize($data);
    }
}
