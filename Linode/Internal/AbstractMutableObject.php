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

use Linode\ValidationException;

/**
 * A Linode object to represent an individual editable resource.
 *
 * This class should not be used or overwritten in userland code.
 */
abstract class AbstractMutableObject extends AbstractImmutableObject implements MutableObjectInterface
{
    /**
     * Returns all mutable properties as an array in form of "['property name' => 'property value']".
     *
     * @return  string[]
     */
    abstract protected function getMutableProperties();

    /**
     * Sets new value of specified property.
     *
     * @param   string $name
     * @param   string $value
     *
     * @throws  ValidationException
     */
    public function __set($name, $value)
    {
        if ($name === 'id') {
            throw new ValidationException('[id] This property is immutable.');
        }

        if (property_exists($this, $name)) {

            $violations = $this->validator->validatePropertyValue($this, $name, $value);

            if ($violations->count() !== 0) {

                $violation = $violations->get(0);
                $message   = sprintf('[%s] %s', $violation->getPropertyPath(), $violation->getMessage());

                throw new ValidationException($message);
            }

            $this->$name = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $endpoint   = $this->getEndpoint();
        $parameters = $this->getMutableProperties();

        $result = ($this->id === null)
            ? $this->client->apiPost($endpoint, $parameters)
            : $this->client->apiPut($endpoint, $parameters);

        $this->initialize($result);
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        if ($this->id !== null) {
            $this->client->apiDelete($this->getEndpoint());
            $this->id = null;
        }
    }
}
