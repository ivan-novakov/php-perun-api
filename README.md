# PHP Perun API

A client library written in PHP to consume [Perun](http://perun.metacentrum.cz/web/index.shtml) REST API.

## Intro

This software is being developed as a part of the Shongo Project initiated by [CESNET, a. l. e.](http://www.ces.net/).


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


## Usage

Perun client configuration consists of several basic sections. The `client` section is used for general configuration such as the `url` of the Perun API instance.
The `http_client` section configures the standard HTTP client object from Zend Framework 2. The `authenticator` section configures the client authentication of the HTTP requests.

    $clientConfig = array(
        
        'client' => array(
            'url' => 'https://api.example.org/rest'
        ), 
        
        'http_client' => array(
            'adapter' => 'Zend\Http\Client\Adapter\Curl', 
            'useragent' => 'Perun Client', 
            'curloptions' => array(
                CURLOPT_SSL_VERIFYPEER => true, 
                CURLOPT_SSL_VERIFYHOST => 2, 
                CURLOPT_CAINFO => '/etc/ssl/certs/ca-bundle.pem'
            )
        ), 
        
        'authenticator' => array(
            'class' => 'InoPerunApi\Client\Authenticator\BasicAuth', 
            'options' => array(
                'cookie_name' => 'PERUNSESSION', 
                'cookie_value' => '_cookie_value_', 
                'authorization' => 'Basic _hashed_username_and_password_'
            )
        )
    );
    
Once the we have the configuration, we can initialize the client:

    use InoPerunApi\Client\ClientFactory;
    
    $clientConfig = array(...);
    
    $clientFactory = new ClientFactory();
    $client = $clientFactory->createClient($config);
    
After that, we can send requests to the remote API. For each Perun entity, there is a dedicated "manager" object, which can handle calls specific to the corresponding entity. For example, to get the user by its ID, we need to call the `getUserById` method of the `usersManager`. Any method arguments we need to pass should be included in the third argument of the `sendRequest` call:

    try {
        $perunResponse = $client->sendRequest('usersManager', 'getUserById', array(
            'id' => 1234
        ));
    } catch (\Exception $e) {
        // handle exception
    }

If there are problems while connecting to the remote API or if the response cannot be parsed properly, an exception will be thrown. Otherwise, we still need to check, if the request was successful:

    if ($perunResponse->isError()) {
        printf("Perun error [%s]: %s (%s)\n", $perunResponse->getErrorId(), 
            $perunResponse->getErrorType(), $perunResponse->getErrorMessage());
    }
    
If there is no error, we can access the response through the `Payload` object:

    $payload = $perunResponse->getPayload();
    printf("User: %s %s\n", $payload->getParam('firstName'), $payload->getParam('lastName));
    
    
## Advanced usage (experimental)

The library may be used in a more intuitive way, which tries to "hide" the fact, that we are calling a remote API. The library tries to "mimic" the remote manager and entity objects:

    $usersManager = new GenericManager($client);
    $usersManager->setManagerName('usersManager');
    
    $user = $usersManager->getUserById(array(
        'user' => 1234
    ));
    
    printf("User: %s %s\n", $user->getFirstName(), $user->getLastName());
    
We instantiate a "manager" object and pass a client object instance to its constructor. When we call a method on this object, it is caught by the magic `__call()` method and a client request is constructed and dispatched. If the call was succesful, the `User` entity is populated with data and returned.

    
## License

* [BSD 3 Clause](http://debug.cz/license/bsd-3-clause)


## Links

* [The Perun Project](http://perun.metacentrum.cz/web/index.shtml)
* [CESNET](http://www.ces.net/)


## Author

* [Ivan Novakov](http://novakov.cz/)
