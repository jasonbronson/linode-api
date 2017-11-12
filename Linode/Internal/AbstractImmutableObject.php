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
 * A Linode object to represent an individual read-only resource.
 *
 * This class should not be used or overwritten in userland code.
 */
abstract class AbstractImmutableObject extends AbstractObject implements ImmutableObjectInterface
{
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
