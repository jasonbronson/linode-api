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

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * A Linux distribution supported by Linode.
 *
 * @property    string  $label               The user-friendly name of this distribution.
 * @property    string  $vendor              The upstream distribution vendor. Consistent between releases of a distro.
 * @property    string  $created             ISO 8601 datetime.
 * @property    int     $minimum_image_size  The minimum size required for the distrbution image.
 * @property    bool    $x64                 TRUE if this is a 64-bit distribution.
 * @property    bool    $recommended         TRUE if this distribution is recommended by Linode.
 * @property    bool    $experimental        TRUE if this distribution is a beta or preview release.
 */
class Distribution extends Internal\AbstractImmutableObject
{
    protected $label;
    protected $vendor;
    protected $created;
    protected $minimum_image_size;
    protected $x64;
    protected $recommended;
    protected $experimental;

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return rtrim('/distributions/' . $this->id, '/');
    }

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('label', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('vendor', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('created', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('minimum_image_size', [
            new Constraints\Type(['type' => 'int']),
            new Constraints\NotNull(),
            new Constraints\GreaterThanOrEqual(['value' => 0]),
        ]);

        $metadata->addPropertyConstraints('x64', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('recommended', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('experimental', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);
    }
}
