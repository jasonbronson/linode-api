<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Service;

use Linode\Enum\ServiceTypeEnum;
use Linode\Internal\AbstractImmutableObject;
use Linode\LinodeClient;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A service available for purchase from Linode.
 *
 * @property    string  $service_type   The type of service offered.
 * @property    string  $label          Human-friendly name of this service.
 * @property    string  $hourly_price   Cost (in cents) per hour.
 * @property    string  $monthly_price  Cost (in cents) per month.
 */
abstract class Service extends AbstractImmutableObject
{
    protected $service_type;
    protected $label;
    protected $hourly_price;
    protected $monthly_price;

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return rtrim('/services/' . $this->id, '/');
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('service_type', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
            new Constraints\Choice(['callback' => ['Linode\Enum\ServiceTypeEnum', 'keys']]),
        ]);

        $metadata->addPropertyConstraints('label', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('hourly_price', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('monthly_price', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getInstance(LinodeClient $client, array $data = [], $parent = null)
    {
        $reflectionClass = new \ReflectionClass(ServiceTypeEnum::get($data['service_type']));

        $object = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod(self::class, '__construct');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($object, $client, $data);

        return $object;
    }
}
