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

use Linode\Collection;
use Linode\DnsZoneRecord\DnsZoneRecord;
use Linode\Enum\DnsZoneTypeEnum;
use Linode\Internal\AbstractMutableObject;
use Linode\LinodeClient;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A DNS Zone.
 *
 * @property    string    $type           DNS Zone type (@see "Linode\Enum\DnsZoneTypeEnum").
 * @property    string    $status         Current status of the DNS Zone (@see "Linode\Enum\DnsZoneStatusEnum").
 * @property    string    $dnszone        The DNS Zone name.
 * @property    string    $description    A description to keep track of this DNS Zone.
 * @property    string    $display_group  A display group to keep track of this DNS Zone.
 * @property    string[]  $axfr_ips       An array of IP addresses allowed to AXFR the entire DNS Zone.
 */
abstract class DnsZone extends AbstractMutableObject
{
    protected $type;
    protected $status;
    protected $dnszone;
    protected $description;
    protected $display_group;
    protected $axfr_ips;

    /**
     * Returns list of DNS Zone records.
     *
     * @return  Collection|\Linode\DnsZoneRecord\DnsZoneRecord[]
     * @throws  \Linode\LinodeException
     */
    public function getRecords()
    {
        $endpoint = $this->getEndpoint() . '/records';

        return new Collection($this->client, DnsZoneRecord::class, $endpoint, 'records');
    }

    /**
     * Finds specified DNS Zone record.
     *
     * @param   string $id Record ID.
     *
     * @return  \Linode\DnsZoneRecord\DnsZoneRecord
     * @throws  \Linode\LinodeException
     */
    public function getRecord($id)
    {
        $endpoint = $this->getEndpoint() . '/records/' . $id;

        return DnsZoneRecord::getInstance($this->client, $this->client->apiGet($endpoint), $this->id);
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return rtrim('/dnszones/' . $this->id, '/');
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('type', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Choice(['callback' => ['Linode\Enum\DnsZoneTypeEnum', 'keys']]),
        ]);

        $metadata->addPropertyConstraints('status', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Choice(['callback' => ['Linode\Enum\DnsZoneStatusEnum', 'keys']]),
        ]);

        $metadata->addPropertyConstraints('dnszone', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('description', [
            new Constraints\Type(['type' => 'string']),
        ]);

        $metadata->addPropertyConstraints('display_group', [
            new Constraints\Type(['type' => 'string']),
        ]);

        $metadata->addPropertyConstraints('axfr_ips', [
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

    /**
     * {@inheritdoc}
     */
    public static function getInstance(LinodeClient $client, array $data = [], $parent = null)
    {
        $reflectionClass = new \ReflectionClass(DnsZoneTypeEnum::get($data['type']));

        $object = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod(self::class, '__construct');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($object, $client, $data);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMutableProperties()
    {
        return [
            'status'        => $this->status,
            'dnszone'       => $this->dnszone,
            'description'   => $this->description,
            'display_group' => $this->display_group,
            'axfr_ips'      => $this->axfr_ips,
        ];
    }
}
