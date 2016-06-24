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
 * An object with editable data.
 */
interface MutableObjectInterface extends ImmutableObjectInterface
{
    /**
     * Saves Linode object. In case of new object it must be created.
     *
     * @throws  LinodeException
     */
    public function save();

    /**
     * Deletes Linode object.
     *
     * @throws  LinodeException
     */
    public function delete();
}
