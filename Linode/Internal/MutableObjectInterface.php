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

/**
 * An object with editable data.
 */
interface MutableObjectInterface extends ImmutableObjectInterface
{
    /**
     * Saves Linode object. In case of new object it will be created.
     *
     * @throws  \Linode\LinodeException
     */
    public function save();

    /**
     * Deletes Linode object.
     *
     * @throws  \Linode\LinodeException
     */
    public function delete();
}
