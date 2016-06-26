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
 * A Linux kernel that can be booted on a Linode.
 *
 * @property    string  $id           A string.
 * @property    bool    $kvm          If this kernel is suitable for KVM Linodes.
 * @property    string  $label        The user-friendly name of this kernel.
 * @property    string  $created      ISO 8601 datetime.
 * @property    bool    $xen          If this kernel is suitable for Xen Linodes.
 * @property    string  $version      Linux Kernel version.
 * @property    string  $description  Additional, descriptive text about the kernel.
 * @property    bool    $deprecated   TRUE if this kernel is deprecated.
 * @property    string  $updates      A kernel ID that this provides an update to.
 * @property    bool    $x64          TRUE if this is a 64-bit kernel, FALSE for 32-bit.
 */
class Kernel extends AbstractImmutableObject implements ValidatedObjectInterface
{
    protected $id;
    protected $kvm;
    protected $label;
    protected $created;
    protected $xen;
    protected $version;
    protected $description;
    protected $deprecated;
    protected $updates;
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

        $metadata->addPropertyConstraints('kvm', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('label', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('created', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('xen', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('version', [
            new Constraints\Type(['type' => 'string']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('description', [
            new Constraints\Type(['type' => 'string']),
        ]);

        $metadata->addPropertyConstraints('deprecated', [
            new Constraints\Type(['type' => 'bool']),
            new Constraints\NotNull(),
        ]);

        $metadata->addPropertyConstraints('updates', [
            new Constraints\Type(['type' => 'string']),
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
        return $this->id === null ? false : '/kernels/' . $this->id;
    }
}
