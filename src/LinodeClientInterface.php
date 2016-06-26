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
 * Linode API client public functions.
 */
interface LinodeClientInterface
{
    /**
     * Returns list of datacenters.
     *
     * @return  Collection|Datacenter[]
     * @throws  LinodeException
     */
    public function getDatacenters();

    /**
     * Finds specified datacenter.
     *
     * @param   string $id Datacenter ID.
     *
     * @return  Datacenter
     * @throws  LinodeException
     */
    public function findDatacenter($id);

    /**
     * Returns list of distributions.
     *
     * @param   bool $recommended Get recommended distributions only.
     *
     * @return  Collection|Distribution[]
     * @throws  LinodeException
     */
    public function getDistributions($recommended = true);

    /**
     * Finds specified distribution.
     *
     * @param   string $id Distribution ID.
     *
     * @return  Distribution
     * @throws  LinodeException
     */
    public function findDistribution($id);
}
