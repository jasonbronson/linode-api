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
 * An object with read-only data.
 */
interface ImmutableObjectInterface
{
    /**
     * Reloads Linode object.
     *
     * @throws  LinodeException
     */
    public function refresh();
}
