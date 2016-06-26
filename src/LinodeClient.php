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

use AltrEgo\AltrEgo;
use Linode\Internal\ApiBridge;

/**
 * Linode API client.
 */
final class LinodeClient implements LinodeClientInterface
{
    private $api;

    /**
     * Constructor.
     *
     * @param   string $token   
     * @param   string $baseUrl 
     */
    public function __construct($token = null, $baseUrl = 'https://api.linode.com/v4')
    {
        $this->api = new ApiBridge($token, $baseUrl);
    }

    /**
     * Performs API GET call as specified.
     *
     * @param   string $endpoint API endpoint.
     * @param   int    $page     Optional page number.
     *
     * @return  array Decoded JSON response otherwise.
     * @throws  LinodeException
     */
    public function apiGet($endpoint, $page = null)
    {
        return $this->api->call(ApiBridge::METHOD_GET, $endpoint, $page === null ? [] : ['page' => $page]);
    }

    /**
     * Performs API POST call as specified.
     *
     * @param   string $endpoint   API endpoint.
     * @param   array  $parameters Optional list of named parameters.
     *
     * @return  array Decoded JSON response otherwise.
     * @throws  LinodeException
     */
    public function apiPost($endpoint, array $parameters = [])
    {
        return $this->api->call(ApiBridge::METHOD_POST, $endpoint, $parameters);
    }

    /**
     * Performs API PUT call as specified.
     *
     * @param   string $endpoint   API endpoint.
     * @param   array  $parameters Optional list of named parameters.
     *
     * @return  array Decoded JSON response otherwise.
     * @throws  LinodeException
     */
    public function apiPut($endpoint, array $parameters = [])
    {
        return $this->api->call(ApiBridge::METHOD_PUT, $endpoint, $parameters);
    }

    /**
     * Performs API DELETE call as specified.
     *
     * @param   string $endpoint   API endpoint.
     * @param   array  $parameters Optional list of named parameters.
     *
     * @return  array Decoded JSON response otherwise.
     * @throws  LinodeException
     */
    public function apiDelete($endpoint, array $parameters = [])
    {
        return $this->api->call(ApiBridge::METHOD_DELETE, $endpoint, $parameters);
    }

    /**
     * Finds specified Linode API resource.
     *
     * @param   string $class PHP class of resource object (must inherit from "AbstractImmutableObject").
     * @param   string $id    Resource ID.
     *
     * @return  Internal\AbstractImmutableObject
     */
    protected function findObject($class, $id)
    {
        $reflectionClass = new \ReflectionClass($class);

        /** @var Internal\AbstractImmutableObject $object */
        $object = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod(Internal\AbstractObject::class, '__construct');
        $reflectionMethod->invoke($object, $this);

        /** @noinspection PhpParamsInspection */
        $reflectionObject = AltrEgo::create($object);

        /** @var \StdClass $reflectionObject */
        $reflectionObject->id = $id;

        $object->refresh();

        return $object;
    }
}
