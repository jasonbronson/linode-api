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

        if ($endpoint === '/distributions' && $method === ApiBridge::METHOD_GET) {

            if (array_key_exists('page', $parameters) && $parameters['page'] === 2) {
                $result = '{"page": 2, "total_pages": 3, "total_results": 21, "distributions": [
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
                $result = '{"page": 3, "total_pages": 3, "total_results": 21, "distributions": [
                    {"id": "distro_139", "minimum_image_size": 1500, "label": "Ubuntu 15.04", "created": "2015-04-23T11:08:05", "experimental": false, "vendor": "Ubuntu", "recommended": false, "x64": true}, 
                    {"id": "distro_140", "minimum_image_size": 900, "label": "Debian 8.1", "created": "2015-04-27T16:26:41", "experimental": false, "vendor": "Debian", "recommended": true, "x64": true}, 
                    {"id": "distro_141", "minimum_image_size": 650, "label": "Fedora 22", "created": "2015-05-26T13:50:58", "experimental": false, "vendor": "Fedora", "recommended": true, "x64": true}, 
                    {"id": "distro_142", "minimum_image_size": 800, "label": "Arch Linux 2015.08", "created": "2015-08-24T11:17:18", "experimental": false, "vendor": "Arch", "recommended": true, "x64": true}, 
                    {"id": "distro_143", "minimum_image_size": 1500, "label": "Ubuntu 15.10", "created": "2015-11-10T14:22:00", "experimental": false, "vendor": "Ubuntu", "recommended": true, "x64": true}]}';
            }
            elseif (!array_key_exists('page', $parameters) || $parameters['page'] === 1) {
                $result = '{"page": 1, "total_pages": 3, "total_results": 21, "distributions": [
                    {"id": "distro_60", "minimum_image_size": 950, "label": "CentOS 5.6", "created": "2009-08-17T00:00:00", "experimental": false, "vendor": "CentOS", "recommended": false, "x64": true}, 
                    {"id": "distro_78", "minimum_image_size": 550, "label": "Debian 6", "created": "2011-02-08T16:54:31", "experimental": false, "vendor": "Debian", "recommended": false, "x64": true}, 
                    {"id": "distro_86", "minimum_image_size": 600, "label": "Slackware 13.37 32bit", "created": "2011-06-05T15:11:59", "experimental": false, "vendor": "Slackware", "recommended": false, "x64": false}, 
                    {"id": "distro_87", "minimum_image_size": 600, "label": "Slackware 13.37", "created": "2011-06-05T15:11:59", "experimental": false, "vendor": "Slackware", "recommended": false, "x64": true}, 
                    {"id": "distro_117", "minimum_image_size": 1000, "label": "Slackware 14.1", "created": "2013-11-25T11:11:02", "experimental": false, "vendor": "Slackware", "recommended": true, "x64": true}, 
                    {"id": "distro_118", "minimum_image_size": 3072, "label": "Gentoo 2013-11-26", "created": "2013-11-26T15:20:31", "experimental": false, "vendor": "Gentoo", "recommended": false, "x64": true}, 
                    {"id": "distro_120", "minimum_image_size": 1024, "label": "openSUSE 13.1", "created": "2013-12-02T12:53:29", "experimental": false, "vendor": "openSUSE", "recommended": false, "x64": true}, 
                    {"id": "distro_122", "minimum_image_size": 1536, "label": "Fedora 20", "created": "2013-01-27T10:00:00", "experimental": false, "vendor": "Fedora", "recommended": false, "x64": true}]}';
            }
        }

        // Parse the response.
        return json_decode($result, true) ?: [];
    }
}
