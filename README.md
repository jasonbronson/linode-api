[![License](https://poser.pugx.org/arodygin/linode-api/license)](https://packagist.org/packages/arodygin/linode-api)
[![PHP](https://img.shields.io/badge/PHP-5.5.9%2B-blue.svg)](https://secure.php.net/migration55)
[![Latest Stable Version](https://poser.pugx.org/arodygin/linode-api/v/stable)](https://packagist.org/packages/arodygin/linode-api)
[![Build Status](https://travis-ci.org/arodygin/php-linode-api.svg?branch=master)](https://travis-ci.org/arodygin/php-linode-api)
[![Code Coverage](https://scrutinizer-ci.com/g/arodygin/php-linode-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/arodygin/php-linode-api/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/arodygin/php-linode-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/arodygin/php-linode-api/?branch=master)

# Linode API Client Library for PHP

The PHP library for the [Linode API v4](https://developers.linode.com).

## Requirements

PHP needs to be a minimum version of PHP 5.5.9.

## Installation

The recommended way to install is via Composer:

```bash
composer require "arodygin/linode-api"
```

## Development

```bash
phpunit --coverage-text
php ./bin/php-cs-fixer fix
```
