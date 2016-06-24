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

use Symfony\Component\Validator\Validation;

/**
 * A Linode object is a representation of an individual resource.
 */
class AbstractObject
{
    /** @var LinodeClient */
    protected $client;

    /** @var \Symfony\Component\Validator\Validator\ValidatorInterface */
    private $validator;

    /**
     * Initializes object properties from specified associated array.
     *
     * @param   LinodeClient $client Linode API client.
     * @param   array        $data   Object data.
     *
     * @throws  ValidationException
     */
    public function __construct(LinodeClient $client, array $data = [])
    {
        $this->client = $client;

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
        ;

        $violations = $this->validator->validate($this);

        if ($violations->count() !== 0) {

            $violation = $violations->get(0);
            $message   = sprintf('[%s] %s', $violation->getPropertyPath(), $violation->getMessage());

            throw new ValidationException($message);
        }
    }

    /**
     * @param   string $name
     *
     * @return  bool
     */
    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    /**
     * @param   string $name
     * @param   string $value
     *
     * @throws  ValidationException
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {

            $violations = $this->validator->validatePropertyValue($this, $name, $value);

            if ($violations->count() !== 0) {

                $violation = $violations->get(0);
                $message   = sprintf('[%s] %s', $violation->getPropertyPath(), $violation->getMessage());

                throw new ValidationException($message);
            }

            $this->$name = $value;
        }
    }

    /**
     * @param   string $name
     *
     * @return  mixed
     */
    public function __get($name)
    {
        return property_exists($this, $name) ? $this->$name : null;
    }
}
