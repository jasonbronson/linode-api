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

    /**
     * Returns list of kernels.
     *
     * @return  Collection|Kernel[]
     * @throws  LinodeException
     */
    public function getKernels();

    /**
     * Finds specified kernel.
     *
     * @param   string $id Kernel ID.
     *
     * @return  Kernel
     * @throws  LinodeException
     */
    public function findKernel($id);

    /**
     * Returns list of services.
     *
     * @param   string $type Type of services to return (NULL to return all, @see "Linode\Enum\ServiceTypeEnum").
     *
     * @return  Collection|Service[]
     * @throws  LinodeException
     */
    public function getServices($type = null);

    /**
     * Finds specified service.
     *
     * @param   string $id Service ID.
     *
     * @return  Service
     * @throws  LinodeException
     */
    public function findService($id);
}
