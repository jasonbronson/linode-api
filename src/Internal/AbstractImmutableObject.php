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

/**
 * A Linode object to represent an individual read-only resource.
 *
 * This class should not be used or overwritten in userland code.
 */
abstract class AbstractImmutableObject extends AbstractObject implements ImmutableObjectInterface
{
    /**
     * Returns API endpoint to retrieve the object.
     *
     * @return  string|false
     */
    abstract protected function getEndpoint();

    /**
     * Initializes object properties with values from specified associated array.
     *
     * @param   LinodeClient $client Linode API client.
     * @param   array        $data   Object data.
     *
     * @throws  ValidationException
     */
    public function __construct(LinodeClient $client, array $data = [])
    {
        parent::__construct($client);

        $this->initialize($data);
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
        $endpoint = $this->getEndpoint();

        if ($endpoint !== false) {
            $result = $this->client->apiGet($endpoint);
            $this->initialize($result);
        }
    }
}
