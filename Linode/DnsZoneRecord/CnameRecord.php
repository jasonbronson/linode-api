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
 * CNAME-record.
 *
 * @property    string  $hostname  Hostname of the alias.
 * @property    string  $alias     Target of the alias.
 */
class CnameRecord extends DnsZoneRecord
{
    protected $hostname;
    protected $alias;

    /**
     * Creates new record.
     *
     * @param   LinodeClient $client   Linode API client.
     * @param   string       $dnszone  DNS Zone ID which this record belongs to.
     * @param   string       $hostname Hostname of the alias.
     * @param   string       $alias    Target of the alias.
     *
     * @throws  \Linode\ValidationException
     */
    public function __construct(LinodeClient $client, $dnszone, $hostname, $alias)
    {
        parent::__construct($client, [
            'type'   => DnsZoneRecordEnum::CNAME,
            'name'   => $hostname,
            'target' => $alias,
        ], $dnszone);
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('hostname', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Length(['max' => 100]),
        ]);

        $metadata->addPropertyConstraints('alias', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMutableProperties()
    {
        $properties = parent::getMutableProperties();

        $properties['name']   = $this->hostname;
        $properties['target'] = $this->alias;

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(array $data = [])
    {
        $properties = [
            'name'   => 'hostname',
            'target' => 'alias',
        ];

        foreach ($properties as $key => $property) {
            if (array_key_exists($key, $data)) {
                $this->$property = $data[$key];
            }
        }

        parent::initialize($data);
    }
}
