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
 * Collection of data objects.
 */
class Collection implements \Countable, \Iterator
{
    /** @var LinodeClient Linode client. */
    protected $client;

    /** @var string PHP class of collection items. */
    protected $class;

    /** @var string API endpoint to get the collection. */
    protected $endpoint;

    /** @var string Key of the item in response which contains data objects list. */
    protected $key;

    /** @var string ID of parent resource if applicable. */
    protected $parent;

    /** @var int Current page (one-based). */
    protected $current_page;

    /** @var int Total number of pages. */
    protected $total_pages;

    /** @var int Total number of results. */
    protected $total_results;

    /** @var array Items of the collection. */
    protected $items = [];

    /** @var int Index of current item (zero-based). */
    protected $current_item = 0;

    /**
     * Constructor.
     *
     * @param   LinodeClient $client   Linode client.
     * @param   string       $class    PHP class of collection items.
     * @param   string       $endpoint API endpoint to get the collection.
     * @param   string       $key      Key of the item in response which contains data objects list.
     * @param   string       $parent   ID of parent resource if applicable.
     *
     * @throws  LinodeException
     */
    public function __construct(LinodeClient $client, $class, $endpoint, $key, $parent = null)
    {
        $this->client   = $client;
        $this->class    = $class;
        $this->endpoint = $endpoint;
        $this->key      = $key;
        $this->parent   = $parent;

        $this->parseResponse($client->apiGet($endpoint));
    }

    /**
     * Parses the API response and updates the collection.
     *
     * @param   array $response Response from Linode API call.
     *
     * @throws  LinodeException
     */
    protected function parseResponse($response) {

        $properties = ['page', 'total_pages', 'total_results', $this->key];

        foreach ($properties as $property) {
            if (!array_key_exists($property, $response)) {
                throw new LinodeException([$property => 'Expected property not found.']);
            }
        }

        $this->current_page  = $response['page'];
        $this->total_pages   = $response['total_pages'];
        $this->total_results = $response['total_results'];

        foreach ($response[$this->key] as $data) {

            $reflectionMethod = new \ReflectionMethod($this->class, 'getInstance');

            $this->items[] = $reflectionMethod->invoke(null, $this->client, $data, $this->parent);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->total_results;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->items[$this->current_item];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->current_item++;

        if ($this->current_item === count($this->items) && $this->current_page < $this->total_pages) {
            $this->parseResponse($this->client->apiGet($this->endpoint, $this->current_page + 1));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->current_item;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->current_item < $this->total_results;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->current_item = 0;
    }
}
