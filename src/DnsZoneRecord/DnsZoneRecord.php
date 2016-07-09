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
use Linode\Internal\AbstractMutableObject;
use Linode\LinodeClient;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A DNS Zone Record.
 *
 * @property    string  $type     Record type (@see "Linode\Enum\DnsZoneRecordEnum").
 * @property    string  $ttl_sec  Time interval that the resource record may be cached before it should be discarded, in seconds.
 */
abstract class DnsZoneRecord extends AbstractMutableObject
{
    protected $type;
    protected $ttl_sec;

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return rtrim('/dnszones/' . $this->parent . '/records/' . $this->id, '/');
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('type', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Choice(['callback' => ['Linode\Enum\DnsZoneRecordEnum', 'keys']]),
        ]);

        $metadata->addPropertyConstraints('ttl_sec', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getInstance(LinodeClient $client, array $data = [], $parent = null)
    {
        $reflectionClass = new \ReflectionClass(DnsZoneRecordEnum::get($data['type']));

        $object = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod(self::class, '__construct');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($object, $client, $data, $parent);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMutableProperties()
    {
        return [
            'ttl_sec' => $this->ttl_sec,
        ];
    }
}
