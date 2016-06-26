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

use Linode\Internal\AbstractImmutableObject;
use Linode\Internal\ValidatedObjectInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A Linux distribution supported by Linode.
 *
 * @property    string  $id                  A string.
 * @property    int     $minimum_image_size  The minimum size required for the distrbution image.
 * @property    string  $label               The user-friendly name of this distribution.
 * @property    string  $created             ISO 8601 datetime.
 * @property    bool    $experimental        TRUE if this distribution is a beta or preview release.
 * @property    string  $vendor              The upstream distribution vendor. Consistent between releases of a distro.
 * @property    bool    $recommended         TRUE if this distribution is recommended by Linode.
 * @property    bool    $x64                 TRUE if this is a 64-bit distribution.
 */
class Distribution extends AbstractImmutableObject implements ValidatedObjectInterface
{
    protected $id;
    protected $minimum_image_size;
    protected $label;
    protected $created;
    protected $experimental;
    protected $vendor;
    protected $recommended;
    protected $x64;

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('id', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('minimum_image_size', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('label', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('created', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('experimental', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('vendor', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('recommended', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('x64', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return $this->id === null ? false : '/distributions/' . $this->id;
    }
}
