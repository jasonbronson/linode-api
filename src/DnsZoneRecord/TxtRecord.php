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
 * TXT-record.
 *
 * @property    string  $name   Name of the record.
 * @property    string  $value  Value of the record.
 */
class TxtRecord extends DnsZoneRecord
{
    protected $name;
    protected $value;

    /**
     * Creates new record.
     *
     * @param   LinodeClient $client  Linode API client.
     * @param   string       $dnszone DNS Zone ID which this record belongs to.
     * @param   string       $name    Name of the record.
     * @param   string       $value   Value of the record.
     *
     * @throws  \Linode\ValidationException
     */
    public function __construct(LinodeClient $client, $dnszone, $name = null, $value = null)
    {
        parent::__construct($client, [
            'type'   => DnsZoneRecordEnum::TXT,
            'name'   => $name,
            'target' => $value,
        ], $dnszone);
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('name', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\Length(['max' => 100]),
        ]);

        $metadata->addPropertyConstraints('value', [
            new Constraints\Type(['type' => 'string']),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMutableProperties()
    {
        $properties = parent::getMutableProperties();

        $properties['name']   = $this->name;
        $properties['target'] = $this->value;

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(array $data = [])
    {
        $properties = [
            'name'   => 'name',
            'target' => 'value',
        ];

        foreach ($properties as $key => $property) {
            if (array_key_exists($key, $data)) {
                $this->$property = $data[$key];
            }
        }

        parent::initialize($data);
    }
}
