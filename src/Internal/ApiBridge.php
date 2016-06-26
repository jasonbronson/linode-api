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

use Linode\LinodeException;

/**
 * Implements interaction with API endpoints.
 *
 * This class should not be used or overwritten in userland code.
 */
final class ApiBridge
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
     * Performs API call as specified.
     *
     * @param   string $method     HTTP method.
     * @param   string $endpoint   API endpoint.
     * @param   array  $parameters Optional list of named parameters.
     *
     * @return  array Decoded JSON response otherwise.
     * @throws  LinodeException
     */
    public function call($method, $endpoint, array $parameters = [])
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

        if (count($parameters) !== 0) {
            if ($method === self::METHOD_GET) {
                $options[CURLOPT_URL] .= '?' . http_build_query($parameters);
            }
            else {
                $options[CURLOPT_POSTFIELDS] = json_encode($parameters);
            }
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
            throw new LinodeException($this->retrieveErrors($json));
        }

        return $json;
    }

    /**
     * Retrieves error messages from received JSON response.
     *
     * Linode API endpoints have different ways to return errors depending on the situation and root cause:
     *
     *     { "message": "Error description." }
     *     { "reason": "Error description.", "error": true }
     *     { "errors" : [{ "reason": "Error description.", "field": "Optional field name." }] }
     *     { "message" : [{ "reason": "Error description.", "field": "Optional field name." }] }
     *
     * @param   array $json Decoded JSON response.
     *
     * @return  array List of errors.
     */
    protected function retrieveErrors($json)
    {
        // Standard error message(s) is/are returned.
        if (array_key_exists('message', $json)) {
            if (is_array($json['message'])) {
                return $this->getErrors($json['message']);
            }
            else {
                return [$json['message']];
            }
        }

        // Single API error message is returned.
        if (array_key_exists('reason', $json)) {
            return [$json['reason']];
        }

        // Multiple API error messages are returned.
        if (array_key_exists('errors', $json)) {
            return $this->getErrors($json['errors']);
        }

        // No errors found.
        return [];
    }

    /**
     * Converts received collection of API errors into LinodeException errors.
     *
     * The collection is always in the following form:
     *
     *     [{ "reason": "Error description.", "field": "Optional field name." }]
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
