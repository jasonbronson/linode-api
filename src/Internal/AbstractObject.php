<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal;

use Linode\LinodeClient;
use Linode\ValidationException;
use Symfony\Component\Validator\Validation;

/**
 * A Linode object to represent an individual resource.
 *
 * This class should not be used or overwritten in userland code.
 *
 * @property-read   string  $id  Unique resource ID.
 */
abstract class AbstractObject implements ObjectInterface
{
    /** @var \Symfony\Component\Validator\Validator\ValidatorInterface */
    protected $validator;

    /** @var LinodeClient */
    protected $client;

    /** @var string */
    protected $parent;

    /** @var string */
    protected $id;

    /**
     * Initializes object properties with values from specified associated array.
     *
     * @param   LinodeClient $client Linode API client.
     * @param   array        $data   Object data.
     * @param   string       $parent ID of parent resource if applicable.
     *
     * @throws  ValidationException
     */
    protected function __construct(LinodeClient $client, array $data = [], $parent = null)
    {
        $this->client = $client;
        $this->parent = $parent;

        $this->validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
        ;

        $this->initialize($data);
    }

    /**
     * Re-initializes object properties with values from specified associated array.
     *
     * @param   array $data Object data.
     *
     * @throws  ValidationException
     */
    protected function initialize(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $violations = $this->validator->validate($this);

        if ($violations->count() !== 0) {

            $violation = $violations->get(0);
            $message   = sprintf('[%s] %s', $violation->getPropertyPath(), $violation->getMessage());

            throw new ValidationException($message);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getInstance(LinodeClient $client, array $data = [], $parent = null)
    {
        $reflectionClass = new \ReflectionClass(static::class);

        $object = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod(self::class, '__construct');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($object, $client, $data, $parent);

        return $object;
    }
}
