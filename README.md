# PHP Perun API

A client library written in PHP to consume [Perun](http://perun.metacentrum.cz/web/index.shtml) REST API


## Requirements

* PHP >= 5.3.3
* cURL PHP extension


## Installation

### With Composer

To install the library through [composer](http://getcomposer.org/), add the following requirement to your `composer.json` file:

    "require": {
        "ivan-novakov/php-perun-api": "dev-master"
    }

And run `composer install/update`.

### Without composer

Just clone the repository and make sure, that your autoloader is properly set to search for the `InoPerunApi` namespace in the project's `src` directory.
