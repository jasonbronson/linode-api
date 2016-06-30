<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode;

trait TestTrait
{
    /**
     * Sets specified protected property of the object.
     *
     * @param   mixed  $object
     * @param   string $name
     * @param   mixed  $value
     */
    public function setProtectedProperty($object, $name, $value)
    {
        $reflection = new \ReflectionProperty(get_class($object), $name);
        $reflection->setAccessible(true);
        $reflection->setValue($object, $value);
    }
}
