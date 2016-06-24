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

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A Linode object is a representation of an individual resource.
 */
interface ObjectInterface
{
    /**
     * Loads validation constraints for object properties.
     *
     * @param   ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata);
}
