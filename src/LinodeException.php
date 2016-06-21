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
 * Exception for Linode API errors.
 *
 * Instance may contain multiple errors.
 * Code stores HTTP status code of the last operation.
 */
class LinodeException extends \Exception implements \Countable, \Iterator
{
    private $messages;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $messages = [], $code = 400, \Exception $previous = null)
    {
        $this->messages = $messages;

        parent::__construct(reset($messages) ?: 'Unknown error.', $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->messages);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->messages);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->messages);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->messages);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return key($this->messages) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->messages);
    }
}
