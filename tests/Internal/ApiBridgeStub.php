<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode\Internal;

use Linode\Internal\ApiBridge;

/**
 * Stub for API bridge.
 */
class ApiBridgeStub
{
    /**
     * Performs API call as specified.
     *
     * @param   string $method     HTTP method.
     * @param   string $endpoint   API endpoint.
     * @param   array  $parameters Optional list of named parameters.
     *
     * @return  array Decoded JSON response otherwise.
     */
    public function call($method, $endpoint, array $parameters = [])
    {
        $result = '';

        $endpoints = [
            '/datacenters' => [
                ApiBridge::METHOD_GET => 'getDatacenters',
            ],
            '/datacenters/datacenter_6' => [
                ApiBridge::METHOD_GET => 'getDatacenter',
            ],
            '/distributions' => [
                ApiBridge::METHOD_GET => 'getDistributions',
            ],
            '/distributions/recommended' => [
                ApiBridge::METHOD_GET => 'getRecommendedDistributions',
            ],
            '/distributions/distribution_126' => [
                ApiBridge::METHOD_GET => 'getDistribution',
            ],
            '/kernels' => [
                ApiBridge::METHOD_GET => 'getKernels',
            ],
            '/kernels/kernel_137' => [
                ApiBridge::METHOD_GET => 'getKernel',
            ],
        ];

        if (array_key_exists($endpoint, $endpoints)) {
            $methods = $endpoints[$endpoint];

            if (array_key_exists($method, $methods)) {
                $name   = $methods[$method];
                $result = $this->$name($parameters);
            }
        }

        // Parse the response.
        return json_decode($result, true) ?: [];
    }

    /**
     * Emulates response from GET '/datacenters' endpoint.
     *
     * @return  string JSON response.
     */
    protected function getDatacenters()
    {
        return '{"page": 1, "total_pages": 1, "total_results": 8, "datacenters": [
                {"id": "datacenter_2", "label": "Dallas, TX", "datacenter": "dallas"}, 
                {"id": "datacenter_3", "label": "Fremont, CA", "datacenter": "fremont"}, 
                {"id": "datacenter_4", "label": "Atlanta, GA", "datacenter": "atlanta"}, 
                {"id": "datacenter_6", "label": "Newark, NJ", "datacenter": "newark"}, 
                {"id": "datacenter_7", "label": "London, UK", "datacenter": "london"}, 
                {"id": "datacenter_8", "label": "Tokyo, JP", "datacenter": "tokyo"}, 
                {"id": "datacenter_9", "label": "Singapore, SG", "datacenter": "singapore"}, 
                {"id": "datacenter_10", "label": "Frankfurt, DE", "datacenter": "frankfurt"}]}';
    }

    /**
     * Emulates response from GET '/datacenters/:id' endpoint.
     *
     * @return  string JSON response.
     */
    protected function getDatacenter()
    {
        return '{"id": "datacenter_6", "label": "Newark, NJ", "datacenter": "newark"}';
    }

    /**
     * Emulates response from GET '/distributions' endpoint.
     *
     * @param   array  $parameters Optional list of named parameters.
     *
     * @return  string JSON response.
     */
    protected function getDistributions(array $parameters = [])
    {
        if (array_key_exists('page', $parameters) && $parameters['page'] === 2) {
            return '{"page": 2, "total_pages": 3, "total_results": 21, "distributions": [
                    {"id": "distro_126", "minimum_image_size": 550, "label": "Ubuntu 12.04 LTS", "created": "2014-04-28T14:16:59", "experimental": false, "vendor": "Ubuntu", "recommended": false, "x64": true}, 
                    {"id": "distro_127", "minimum_image_size": 675, "label": "CentOS 6.5", "created": "2014-04-28T15:19:34", "experimental": false, "vendor": "CentOS", "recommended": false, "x64": true}, 
                    {"id": "distro_129", "minimum_image_size": 750, "label": "CentOS 7", "created": "2014-07-08T10:07:21", "experimental": false, "vendor": "CentOS", "recommended": true, "x64": true}, 
                    {"id": "distro_130", "minimum_image_size": 600, "label": "Debian 7", "created": "2014-09-24T13:59:32", "experimental": false, "vendor": "Debian", "recommended": true, "x64": true}, 
                    {"id": "distro_134", "minimum_image_size": 650, "label": "Fedora 21", "created": "2014-12-10T16:56:28", "experimental": false, "vendor": "Fedora", "recommended": false, "x64": true}, 
                    {"id": "distro_135", "minimum_image_size": 700, "label": "openSUSE 13.2", "created": "2014-12-17T17:55:42", "experimental": false, "vendor": "openSUSE", "recommended": true, "x64": true}, 
                    {"id": "distro_137", "minimum_image_size": 2000, "label": "Gentoo 2014.12", "created": "2014-12-24T18:00:09", "experimental": false, "vendor": "Gentoo", "recommended": true, "x64": true}, 
                    {"id": "distro_138", "minimum_image_size": 800, "label": "Arch Linux 2015.02", "created": "2015-02-20T14:17:16", "experimental": false, "vendor": "Arch", "recommended": false, "x64": true}]}';
        }
        elseif (array_key_exists('page', $parameters) && $parameters['page'] === 3) {
            return '{"page": 3, "total_pages": 3, "total_results": 21, "distributions": [
                    {"id": "distro_139", "minimum_image_size": 1500, "label": "Ubuntu 15.04", "created": "2015-04-23T11:08:05", "experimental": false, "vendor": "Ubuntu", "recommended": false, "x64": true}, 
                    {"id": "distro_140", "minimum_image_size": 900, "label": "Debian 8.1", "created": "2015-04-27T16:26:41", "experimental": false, "vendor": "Debian", "recommended": true, "x64": true}, 
                    {"id": "distro_141", "minimum_image_size": 650, "label": "Fedora 22", "created": "2015-05-26T13:50:58", "experimental": false, "vendor": "Fedora", "recommended": true, "x64": true}, 
                    {"id": "distro_142", "minimum_image_size": 800, "label": "Arch Linux 2015.08", "created": "2015-08-24T11:17:18", "experimental": false, "vendor": "Arch", "recommended": true, "x64": true}, 
                    {"id": "distro_143", "minimum_image_size": 1500, "label": "Ubuntu 15.10", "created": "2015-11-10T14:22:00", "experimental": false, "vendor": "Ubuntu", "recommended": true, "x64": true}]}';
        }
        elseif (!array_key_exists('page', $parameters) || $parameters['page'] === 1) {
            return '{"page": 1, "total_pages": 3, "total_results": 21, "distributions": [
                    {"id": "distro_60", "minimum_image_size": 950, "label": "CentOS 5.6", "created": "2009-08-17T00:00:00", "experimental": false, "vendor": "CentOS", "recommended": false, "x64": true}, 
                    {"id": "distro_78", "minimum_image_size": 550, "label": "Debian 6", "created": "2011-02-08T16:54:31", "experimental": false, "vendor": "Debian", "recommended": false, "x64": true}, 
                    {"id": "distro_86", "minimum_image_size": 600, "label": "Slackware 13.37 32bit", "created": "2011-06-05T15:11:59", "experimental": false, "vendor": "Slackware", "recommended": false, "x64": false}, 
                    {"id": "distro_87", "minimum_image_size": 600, "label": "Slackware 13.37", "created": "2011-06-05T15:11:59", "experimental": false, "vendor": "Slackware", "recommended": false, "x64": true}, 
                    {"id": "distro_117", "minimum_image_size": 1000, "label": "Slackware 14.1", "created": "2013-11-25T11:11:02", "experimental": false, "vendor": "Slackware", "recommended": true, "x64": true}, 
                    {"id": "distro_118", "minimum_image_size": 3072, "label": "Gentoo 2013-11-26", "created": "2013-11-26T15:20:31", "experimental": false, "vendor": "Gentoo", "recommended": false, "x64": true}, 
                    {"id": "distro_120", "minimum_image_size": 1024, "label": "openSUSE 13.1", "created": "2013-12-02T12:53:29", "experimental": false, "vendor": "openSUSE", "recommended": false, "x64": true}, 
                    {"id": "distro_122", "minimum_image_size": 1536, "label": "Fedora 20", "created": "2013-01-27T10:00:00", "experimental": false, "vendor": "Fedora", "recommended": false, "x64": true}]}';
        }

        return '';
    }

    /**
     * Emulates response from GET '/distributions/recommended' endpoint.
     *
     * @return  string JSON response.
     */
    protected function getRecommendedDistributions()
    {
        return '{"page": 1, "total_pages": 1, "total_results": 9, "distributions": [
                {"id": "distro_129", "minimum_image_size": 750, "label": "CentOS 7", "created": "2014-07-08T10:07:21", "experimental": false, "vendor": "CentOS", "recommended": true, "x64": true}, 
                {"id": "distro_130", "minimum_image_size": 600, "label": "Debian 7", "created": "2014-09-24T13:59:32", "experimental": false, "vendor": "Debian", "recommended": true, "x64": true}, 
                {"id": "distro_135", "minimum_image_size": 700, "label": "openSUSE 13.2", "created": "2014-12-17T17:55:42", "experimental": false, "vendor": "openSUSE", "recommended": true, "x64": true}, 
                {"id": "distro_137", "minimum_image_size": 2000, "label": "Gentoo 2014.12", "created": "2014-12-24T18:00:09", "experimental": false, "vendor": "Gentoo", "recommended": true, "x64": true},
                {"id": "distro_140", "minimum_image_size": 900, "label": "Debian 8.1", "created": "2015-04-27T16:26:41", "experimental": false, "vendor": "Debian", "recommended": true, "x64": true}, 
                {"id": "distro_141", "minimum_image_size": 650, "label": "Fedora 22", "created": "2015-05-26T13:50:58", "experimental": false, "vendor": "Fedora", "recommended": true, "x64": true}, 
                {"id": "distro_142", "minimum_image_size": 800, "label": "Arch Linux 2015.08", "created": "2015-08-24T11:17:18", "experimental": false, "vendor": "Arch", "recommended": true, "x64": true}, 
                {"id": "distro_143", "minimum_image_size": 1500, "label": "Ubuntu 15.10", "created": "2015-11-10T14:22:00", "experimental": false, "vendor": "Ubuntu", "recommended": true, "x64": true},
                {"id": "distro_117", "minimum_image_size": 1000, "label": "Slackware 14.1", "created": "2013-11-25T11:11:02", "experimental": false, "vendor": "Slackware", "recommended": true, "x64": true}]}';
    }

    /**
     * Emulates response from GET '/distributions/:id' endpoint.
     *
     * @return  string JSON response.
     */
    protected function getDistribution()
    {
        return '{"id": "distro_126", "minimum_image_size": 550, "label": "Ubuntu 12.04 LTS", "created": "2014-04-28T14:16:59", "experimental": false, "vendor": "Ubuntu", "recommended": false, "x64": true}';
    }

    /**
     * Emulates response from GET '/kernels' endpoint.
     *
     * @return  string JSON response.
     */
    protected function getKernels()
    {
        return '{"page": 1, "total_pages": 1, "total_results": 16, "kernels": [
                {"id": "kernel_137", "kvm": true, "label": "Latest 32 bit (4.1.5-x86-linode80)", "created": "2011-09-01T21:08:55", "xen": true, "version": "4.1.5", "description": "By selecting this kernel, you will always boot with the latest Linux kernel we provide.\n<br><br>\n2011-08-21 - 3.0.0-linode35\n<br>\n2011-09-01 - 3.0.4-linode36\n<br>\n2011-09-12 - 3.0.4-linode37\n<br>\n2011-09-22 - 3.0.4-linode38\n<br>\n2012-01-23 - 3.0.17-linode41\n<br>\n2012-01-30 - 3.0.18-linode43\n<br>\n2012-06-13 - 3.4.2-linode44\n<br>\n2012-08-24 - 3.5.2-linode45\n<br>\n2012-11-10 - 3.6.5-linode47\n<br>\n2013-02-27 - 3.7.10-linode49\n<br>\n2013-03-35 - 3.8.4-linode50\n<br>\n2013-05-14 - 3.9.2-x86-linode51\n<br>\n2013-05-20 - 3.9.3-x86-linode52\n<br>\n2013-10-29 - 3.11.6-x86-linode54\n<br>\n2013-12-30 - 3.12.6-x86-linode55\n<br>\n2014-02-04 - 3.12.9-x86-linode56\n<br>\n2014-03-26 - 3.13.7-x86-linode57\n<br>\n2014-04-30 - 3.14.1-x86-linode58\n<br>\n2014-05-13 - 3.14.4-x86-linode59\n<br>\n2014-06-02 - 3.14.5-x86-linode60\n<br>\n2014-06-02 - 3.14.5-x86-linode61\n<br>\n2014-07-02 - 3.15.3-x86-linode63\n<br>\n2014-07-08 - 3.15.4-x86-linode64\n<br>\n2014-11-03 - 3.17.1-x86-linode66\n<br>\n2014-11-10 - 3.16.5-x86-linode65\n<br>\n2015-06-12 - 4.0.5-x86-linode77\n<br> \n2015-06-25 - 4.1.0-x86-linode78\n<br>\n2015-08-24 - 4.1.5-x86-linode80\n", "deprecated": false, "updates": null, "x64": false}, 
                {"id": "kernel_227", "kvm": true, "label": "4.1.5-x86-linode80", "created": "2015-08-24T15:00:43", "xen": true, "version": "4.1.5", "description": null, "deprecated": false, "updates": null, "x64": false}, 
                {"id": "kernel_224", "kvm": true, "label": "4.1.5-x86-linode79", "created": "2015-08-13T09:00:00", "xen": true, "version": "4.1.5", "description": null, "deprecated": false, "updates": null, "x64": false}, 
                {"id": "kernel_222", "kvm": true, "label": "4.1.0-x86-linode78", "created": "2015-06-22T11:19:32", "xen": true, "version": "4.1.0", "description": null, "deprecated": false, "updates": null, "x64": false}, 
                {"id": "kernel_221", "kvm": true, "label": "4.0.5-x86-linode77", "created": "2015-06-11T09:58:18", "xen": true, "version": "4.0.5", "description": null, "deprecated": false, "updates": null, "x64": false}, 
                {"id": "kernel_226", "kvm": true, "label": "4.1.5-x86_64-linode61", "created": "2015-08-24T15:00:43", "xen": true, "version": "4.1.5", "description": null, "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_225", "kvm": true, "label": "4.1.5-x86_64-linode60 ", "created": "2015-08-13T09:00:00", "xen": true, "version": "4.1.5", "description": null, "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_223", "kvm": true, "label": "4.1.0-x86_64-linode59 ", "created": "2015-06-22T11:19:32", "xen": true, "version": "4.1.0", "description": null, "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_220", "kvm": true, "label": "4.0.5-x86_64-linode58", "created": "2015-06-10T11:31:52", "xen": true, "version": "4.0.5", "description": null, "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_218", "kvm": true, "label": "4.0.4-x86_64-linode57", "created": "2015-05-21T11:15:47", "xen": true, "version": "4.0.4", "description": null, "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_215", "kvm": true, "label": "4.0.2-x86_64-linode56", "created": "2015-05-11T16:56:58", "xen": true, "version": "4.0.2", "description": null, "deprecated": true, "updates": null, "x64": true}, 
                {"id": "kernel_138", "kvm": true, "label": "4.0.1-x86_64-linode55", "created": "2015-05-04T09:43:23", "xen": false, "version": "4.0.1", "description": null, "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_210", "kvm": true, "label": "GRUB 2", "created": "2015-04-29T11:32:30", "xen": false, "version": "2.0.0", "description": "Allows you to boot custom kernels and distributions using GRUB 2", "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_213", "kvm": true, "label": "Direct Disk", "created": "2015-05-04T21:51:43", "xen": false, "version": "", "description": "Boots the disk directly", "deprecated": false, "updates": null, "x64": true}, 
                {"id": "kernel_216", "kvm": true, "label": "GRUB (Legacy)", "created": "2015-04-29T11:32:30", "xen": false, "version": "2.0.0", "description": "Allows you to boot custom kernels and distributions using GRUB Legacy", "deprecated": true, "updates": null, "x64": true}, 
                {"id": "kernel_61", "kvm": true, "label": "Recovery - Finnix (kernel)", "created": "2006-03-29T00:00:00", "xen": true, "version": "4.1.2", "description": null, "deprecated": false, "updates": null, "x64": true}]}';
    }

    /**
     * Emulates response from GET '/kernels/:id' endpoint.
     *
     * @return  string JSON response.
     */
    protected function getKernel()
    {
        return '{"id": "kernel_137", "kvm": true, "label": "Latest 32 bit (4.1.5-x86-linode80)", "created": "2011-09-01T21:08:55", "xen": true, "version": "4.1.5", "description": "By selecting this kernel, you will always boot with the latest Linux kernel we provide.\n<br><br>\n2011-08-21 - 3.0.0-linode35\n<br>\n2011-09-01 - 3.0.4-linode36\n<br>\n2011-09-12 - 3.0.4-linode37\n<br>\n2011-09-22 - 3.0.4-linode38\n<br>\n2012-01-23 - 3.0.17-linode41\n<br>\n2012-01-30 - 3.0.18-linode43\n<br>\n2012-06-13 - 3.4.2-linode44\n<br>\n2012-08-24 - 3.5.2-linode45\n<br>\n2012-11-10 - 3.6.5-linode47\n<br>\n2013-02-27 - 3.7.10-linode49\n<br>\n2013-03-35 - 3.8.4-linode50\n<br>\n2013-05-14 - 3.9.2-x86-linode51\n<br>\n2013-05-20 - 3.9.3-x86-linode52\n<br>\n2013-10-29 - 3.11.6-x86-linode54\n<br>\n2013-12-30 - 3.12.6-x86-linode55\n<br>\n2014-02-04 - 3.12.9-x86-linode56\n<br>\n2014-03-26 - 3.13.7-x86-linode57\n<br>\n2014-04-30 - 3.14.1-x86-linode58\n<br>\n2014-05-13 - 3.14.4-x86-linode59\n<br>\n2014-06-02 - 3.14.5-x86-linode60\n<br>\n2014-06-02 - 3.14.5-x86-linode61\n<br>\n2014-07-02 - 3.15.3-x86-linode63\n<br>\n2014-07-08 - 3.15.4-x86-linode64\n<br>\n2014-11-03 - 3.17.1-x86-linode66\n<br>\n2014-11-10 - 3.16.5-x86-linode65\n<br>\n2015-06-12 - 4.0.5-x86-linode77\n<br> \n2015-06-25 - 4.1.0-x86-linode78\n<br>\n2015-08-24 - 4.1.5-x86-linode80\n", "deprecated": false, "updates": null, "x64": false}';
    }
}
