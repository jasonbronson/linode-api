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
use Linode\Enum\ServiceTypeEnum;
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
     * @param   string $token   Access token.
     * @param   string $baseUrl Base URL for all API endpoints.
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

        $object = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod(Internal\AbstractObject::class, '__construct');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($object, $this);

        /** @noinspection PhpParamsInspection */
        $reflectionObject = AltrEgo::create($object);

        /** @var \StdClass $reflectionObject */
        $reflectionObject->id = $id;

        /** @var Internal\AbstractImmutableObject $object */
        $object->refresh();

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatacenters()
    {
        return new Collection($this, '/datacenters', Datacenter::class, 'datacenters');
    }

    /**
     * {@inheritdoc}
     */
    public function findDatacenter($id)
    {
        return $this->findObject(Datacenter::class, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getDistributions($recommended = true)
    {
        $endpoint = $recommended
            ? '/distributions/recommended'
            : '/distributions';

        return new Collection($this, $endpoint, Distribution::class, 'distributions');
    }

    /**
     * {@inheritdoc}
     */
    public function findDistribution($id)
    {
        return $this->findObject(Distribution::class, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getKernels()
    {
        return new Collection($this, '/kernels', Kernel::class, 'kernels');
    }

    /**
     * {@inheritdoc}
     */
    public function findKernel($id)
    {
        return $this->findObject(Kernel::class, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getServices($type = null)
    {
        $endpoint = $type !== null && ServiceTypeEnum::has($type)
            ? '/services/' . $type
            : '/services';

        return new Collection($this, $endpoint, Service::class, 'services');
    }

    /**
     * {@inheritdoc}
     */
    public function findService($id)
    {
        return $this->findObject(Service::class, $id);
    }
}
