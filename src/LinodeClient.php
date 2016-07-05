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

use Linode\DnsZone\DnsZone;
use Linode\Enum\ServiceTypeEnum;
use Linode\Internal\ApiBridge;
use Linode\Service\Service;

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
     * {@inheritdoc}
     */
    public function getDatacenters()
    {
        return new Collection($this, Datacenter::class, '/datacenters', 'datacenters');
    }

    /**
     * {@inheritdoc}
     */
    public function getDatacenter($id)
    {
        return Datacenter::getInstance($this, $this->apiGet('/datacenters/' . $id));
    }

    /**
     * {@inheritdoc}
     */
    public function getDistributions($recommended = true)
    {
        $endpoint = $recommended
            ? '/distributions/recommended'
            : '/distributions';

        return new Collection($this, Distribution::class, $endpoint, 'distributions');
    }

    /**
     * {@inheritdoc}
     */
    public function getDistribution($id)
    {
        return Distribution::getInstance($this, $this->apiGet('/distributions/' . $id));
    }

    /**
     * {@inheritdoc}
     */
    public function getKernels()
    {
        return new Collection($this, Kernel::class, '/kernels', 'kernels');
    }

    /**
     * {@inheritdoc}
     */
    public function getKernel($id)
    {
        return Kernel::getInstance($this, $this->apiGet('/kernels/' . $id));
    }

    /**
     * {@inheritdoc}
     */
    public function getServices($type = null)
    {
        $endpoint = $type !== null && ServiceTypeEnum::has($type)
            ? '/services/' . $type
            : '/services';

        return new Collection($this, Service::class, $endpoint, 'services');
    }

    /**
     * {@inheritdoc}
     */
    public function getService($id)
    {
        return Service::getInstance($this, $this->apiGet('/services/' . $id));
    }

    /**
     * {@inheritdoc}
     */
    public function getDnsZones()
    {
        return new Collection($this, DnsZone::class, '/dnszones', 'dnszones');
    }

    /**
     * {@inheritdoc}
     */
    public function getDnsZone($id)
    {
        return DnsZone::getInstance($this, $this->apiGet('/dnszones/' . $id));
    }
}
