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
}
