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

use Linode\LinodeClient;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * An object with data being validated.
 */
interface ObjectInterface
{
    /**
     * Returns API endpoint for the object.
     * If the object is new (no ID is set yet), should return an endpoint for creation.
     *
     * @return  string
     */
    public function getEndpoint();

    /**
     * Loads validation constraints for object properties.
     *
     * @param   ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata);

    /**
     * Creates and initializes object properties with values from specified associated array.
     *
     * @param   LinodeClient $client Linode API client.
     * @param   array        $data   Object data.
     * @param   string       $parent ID of parent resource if applicable.
     *
     * @return  static
     * @throws  \Linode\ValidationException
     */
    public static function getInstance(LinodeClient $client, array $data = [], $parent = null);
}
