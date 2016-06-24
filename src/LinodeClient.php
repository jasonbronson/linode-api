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
     *
     * @return  array Decoded JSON response otherwise.
     * @throws  LinodeException
     */
    public function apiGet($endpoint)
    {
        return $this->api->call(ApiBridge::METHOD_GET, $endpoint);
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
}
