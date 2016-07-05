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
     * Calls specified protected method of the object.
     *
     * @param   mixed  $object
     * @param   string $name
     * @param   array  $args
     *
     * @return  mixed
     */
    public function callMethod($object, $name, array $args = [])
    {
        $reflection = new \ReflectionMethod(get_class($object), $name);
        $reflection->setAccessible(true);

        return $reflection->invokeArgs($object, $args);
    }

    /**
     * Sets specified protected property of the object.
     *
     * @param   mixed  $object
     * @param   string $name
     * @param   mixed  $value
     */
    public function setProperty($object, $name, $value)
    {
        $reflection = new \ReflectionProperty(get_class($object), $name);
        $reflection->setAccessible(true);
        $reflection->setValue($object, $value);
    }

    /**
     * Gets specified protected property of the object.
     *
     * @param   mixed  $object
     * @param   string $name
     *
     * @return  mixed
     */
    public function getProperty($object, $name)
    {
        $reflection = new \ReflectionProperty(get_class($object), $name);
        $reflection->setAccessible(true);

        return $reflection->getValue($object);
    }
}
