<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode;

/**
 * A Linode object to represent an individual editable resource.
 */
abstract class AbstractMutableObject extends AbstractImmutableObject implements MutableObjectInterface
{
    /**
     * @param   string $name
     * @param   string $value
     *
     * @throws  ValidationException
     */
    public function __set($name, $value)
    {
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
}
