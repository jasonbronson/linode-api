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
use Symfony\Component\Validator\Validation;

/** @noinspection SingletonFactoryPatternViolationInspection */

/**
 * A Linode object to represent an individual resource.
 *
 * This class should not be used or overwritten in userland code.
 *
 * @property-read   string  $id  Unique resource ID.
 */
abstract class AbstractObject implements ObjectInterface
{
    /** @var LinodeClient */
    protected $client;

    /** @var \Symfony\Component\Validator\Validator\ValidatorInterface */
    protected $validator;

    /** @var string */
    protected $id;

    /**
     * Initializes object.
     *
     * @param   LinodeClient $client Linode API client.
     */
    protected function __construct(LinodeClient $client)
    {
        $this->client = $client;

        $this->validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
        ;
    }
}
