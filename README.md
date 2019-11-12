[![PHP](https://img.shields.io/badge/PHP-5.6%2B-blue.svg)](https://secure.php.net/migration56)

# Linode API for updating your home ip on linodes dns

## Requirements

The PHP library for the [Linode API v4](https://developers.linode.com).
PHP needs to be a minimum version of PHP 7.1.

## Installation

Using both dotenv and webinarium linode api

## Example use

Please see homeipaddress.php for an example of reading the env file
and then changing an existing dns ip address on the fly

`php homeipaddress.php`

If you want to use docker instance just run
`docker-compose up`

Then you can setup on a cron using
`* * * * * docker-compose --project-directory /myprojectdirectory run dynamicdns >> /tmp/crontab.log 2>&1`

## Env example

token=4daf8989c8421e7cbbe
domain=mydomainnamehere.com
