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

/** @noinspection SingletonFactoryPatternViolationInspection */

/**
 * A Linode object to represent an individual read-only resource.
 *
 * This class should not be used or overwritten in userland code.
 */
abstract class AbstractImmutableObject extends AbstractObject implements ImmutableObjectInterface
{
    /**
     * Initializes object properties with values from specified associated array.
     *
     * @param   LinodeClient $client Linode API client.
     * @param   string       $id     Unique resource ID.
     * @param   array        $data   Object data.
     *
     * @throws  ValidationException
     */
    protected function __construct(LinodeClient $client, $id = null, array $data = [])
    {
        parent::__construct($client, $id);

        $this->initialize($data);
    }

    /**
     * Creates and initializes object properties with values from specified associated array.
     *
     * @param   LinodeClient $client Linode API client.
     * @param   string       $id     Unique resource ID.
     * @param   array        $data   Object data.
     *
     * @return  static
     */
    protected static function getInstance(LinodeClient $client, $id, array $data = [])
    {
        $reflectionClass = new \ReflectionClass(static::class);

        $object = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod(self::class, '__construct');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($object, $client, $id, $data);

        return $object;
    }

    /**
     * Re-initializes object properties with values from specified associated array.
     *
     * @param   array $data
     *
     * @throws  ValidationException
     */
    protected function initialize(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $key !== 'id') {
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
     * Checks whether specified property exists in the object.
     *
     * @param   string $name
     *
     * @return  bool
     */
    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    /**
     * Keeps object properties from modifications.
     *
     * @param   string $name
     * @param   mixed  $value
     *
     * @throws  ValidationException
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            throw new ValidationException('This object is immutable.');
        }
    }

    /**
     * Returns current value of specified property.
     *
     * @param   string $name
     *
     * @return  mixed
     */
    public function __get($name)
    {
        return property_exists($this, $name) ? $this->$name : null;
    }

    /**
     * {@inheritdoc}
     */
    public function refresh()
    {
        if ($this->id !== null) {
            $result = $this->client->apiGet($this->getEndpoint());
            $this->initialize($result);
        }
    }
}
