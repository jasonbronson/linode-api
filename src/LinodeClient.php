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
 * Implements interaction with API endpoints.
 */
class LinodeClient
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /** @var string Access token. */
    private $token;

    /** @var string Base URL for all API endpoints. */
    private $baseUrl;

    /**
     * Constructor.
     *
     * @param   string $token   
     * @param   string $baseUrl 
     */
    public function __construct($token = null, $baseUrl = 'https://api.linode.com/v4')
    {
        $this->token   = $token;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Performs API GET call as specified.
     *
     * @param   string $endpoint API endpoint.
     *
     * @return  array Decoded JSON response otherwise.
     *
     * @throws  LinodeException
     */
    public function apiGet($endpoint)
    {
        return $this->callApi(self::METHOD_GET, $endpoint);
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
        return $this->callApi(self::METHOD_POST, $endpoint, $parameters);
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
        return $this->callApi(self::METHOD_PUT, $endpoint, $parameters);
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
        return $this->callApi(self::METHOD_DELETE, $endpoint, $parameters);
    }

    /**
     * Performs API call as specified.
     *
     * @param   string $method     HTTP method.
     * @param   string $endpoint   API endpoint.
     * @param   array  $parameters Optional list of named parameters.
     *
     * @return  array Decoded JSON response otherwise.
     * @throws  LinodeException
     */
    protected function callApi($method, $endpoint, array $parameters = [])
    {
        // Request headers.
        $headers = [
            'Content-Type: application/json',
        ];

        if ($this->token) {
            $headers[] = 'Authorization: token ' . $this->token;
        }

        // Request options.
        $options = [
            CURLOPT_URL            => $this->baseUrl . $endpoint,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
        ];

        if ($method !== self::METHOD_GET && count($parameters) !== 0) {
            $options[CURLOPT_POSTFIELDS] = json_encode($parameters);
        }

        if ($method === self::METHOD_POST) {
            $options[CURLOPT_POST] = true;
        }
        elseif ($method === self::METHOD_PUT) {
            $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
        }
        elseif ($method === self::METHOD_DELETE) {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        // Make the request.
        $curl = curl_init();

        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);
        $code   = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        // Parse the response.
        $json = json_decode($result, true) ?: [];

        // Raise an exception in case of error.
        if ($code >= 400) {

            // Standard error message(s) is/are returned.
            if (array_key_exists('message', $json)) {
                $errors = is_array($json['message'])
                    ? $this->getErrors($json['message'])
                    : [$json['message']];

                throw new LinodeException($errors, $code);
            }

            // Single API error message is returned.
            if (array_key_exists('reason', $json)) {
                throw new LinodeException([$json['reason']], $code);
            }

            // Multiple API error messages are returned.
            if (array_key_exists('errors', $json)) {
                throw new LinodeException($this->getErrors($json['errors']), $code);
            }

            // Unknown error.
            throw new LinodeException();
        }

        return $json;
    }

    /**
     * Converts received collection of API errors into LinodeException errors.
     *
     * @param   array $json
     *
     * @return  array
     */
    protected function getErrors($json)
    {
        $errors = [];

        foreach ($json as $error) {
            if (array_key_exists('field', $error)) {
                $errors[$error['field']] = $error['reason'];
            }
            else {
                $errors[] = $error['reason'];
            }
        }

        return $errors;
    }
}
