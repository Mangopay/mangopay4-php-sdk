MANGOPAY PHP SDK  [![mangopay2-php-sdk-cd](https://github.com/Mangopay/mangopay2-php-sdk/actions/workflows/build.yaml/badge.svg)](https://github.com/Mangopay/mangopay2-php-sdk/actions/workflows/build.yaml) [![Latest Stable Version](https://poser.pugx.org/mangopay/php-sdk-v2/v/stable)](https://packagist.org/packages/mangopay/php-sdk-v2) [![Total Downloads](https://poser.pugx.org/mangopay/php-sdk-v2/downloads)](https://packagist.org/packages/mangopay/php-sdk-v2) [![License](https://poser.pugx.org/mangopay/php-sdk-v2/license)](https://packagist.org/packages/mangopay/php-sdk-v2)
=================================================

MangopaySDK is a PHP client library to work with [Mangopay REST API](https://docs.mangopay.com/endpoints/v2.01).


Compatibility Notes
-------------------------------------------------
* Since v2.1 of this SDK, you must be using at least v2.01 of the API ([more information about the changes required](https://docs.mangopay.com/api-v2-01-overview/))
* If you experience problems with authentification and/or the temporary token file following an SDK update (particularly updating to v2.0 of the SDK), you may need to just delete your temporary file (that you specify with `$api->Config->TemporaryFolder`) - which allows it to be regenerated correctly the next time it's needed

Requirements
-------------------------------------------------
To use this SDK, you will need (as a minimum):
* PHP 5.6 or newer
* cURL (included and enabled in a standard PHP distribution)
* OpenSSL (included and enabled in a standard PHP distribution)
* [psr/log](https://github.com/php-fig/log) v1.0
* You do not have to use [Composer](https://getcomposer.org/), but you are strongly advised to (particularly for handling the dependency on the PSR Log library)

Installation with Composer
-------------------------------------------------
You can use Mangopay SDK library as a dependency in your project with [Composer](https://getcomposer.org/) (which is the preferred technique). Follow [these installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have Composer installed.
A composer.json file is available in the repository, and it has been referenced from [Packagist](https://packagist.org/packages/mangopay/php-sdk-v2).

The installation with Composer is easy and reliable:

Step 1 - Add the Mangopay SDK as a dependency by executing the following command:

    you@yourhost:/path/to/your-project$ composer require mangopay/php-sdk-v2

Step 2 - Update your dependencies with Composer

    you@yourhost:/path/to/your-project$ composer update

Step 3 - Finally, be sure to include the autoloader in your project

    require_once '/path/to/your-project/vendor/autoload.php';

The Library has been added into your dependencies and is ready to be used.


Installation without Composer
-------------------------------------------------
The project attempts to comply with PSR-4 specification for autoloading classes from file paths. As a namespace prefix is `MangoPay\` with base directory `/path/to/your-project/`.

If you're not using PSR-4 or Composer, the installation is as easy as downloading the library and storing it under any location that will be available for including in your project (**don't forget to include the required library dependencies though**):
```php
    require_once '/path/to/your-project/MangoPay/Autoloader.php';
```
Alternatively you can download the package in its entirety (ie with all required dependencies) from the [Releases page](https://github.com/Mangopay/mangopay2-php-sdk/releases) (look for the `mangopay2-php-sdk-[RELEASE_NAME].zip` file).
Uncompress the zip file you download, and include the autoloader in your project:
```php
    require_once '/path/to/your-project/mangopay2-php-sdk/vendor/autoload.php';
```


License
-------------------------------------------------
MangopaySDK is distributed under MIT license, see the [LICENSE file](https://github.com/Mangopay/mangopay2-php-sdk/blob/master/LICENSE).


Unit Tests
-------------------------------------------------
Tests are placed under `/path/to/your-project/tests/`.
The `/tests/suites/all.php` suite runs ALL tests.
You can also use any of `/tests/cases/*.php` to run a single test case.


Contacts
-------------------------------------------------
Report bugs or suggest features using
[issue tracker on GitHub](https://github.com/Mangopay/mangopay2-php-sdk/issues).


Account creation
-------------------------------------------------
You can get yourself a free sandbox account or sign up for a production account by [registering on the Mangopay site](https://www.mangopay.com/start/) (note that validation of your production account involves several steps, so think about doing it in advance of when you actually want to go live).



Configuration
-------------------------------------------------
Using the credential info from the signup process above, you should then set `$api->Config->ClientId` to your Mangopay ClientId and `$api->Config->ClientPassword` to your Mangopay APIKey.

You also need to set a folder path in `$api->Config->TemporaryFolder` that SDK needs
to store temporary files. This path should be outside your www folder.
It could be `/tmp/` or `/var/tmp/` or any other location that PHP can write to.
**You must use different folders for your sandbox and production environments.**

`$api->Config->BaseUrl` is set to sandbox environment by default. To enable production
environment, set it to `https://api.mangopay.com`.

```php
require_once '/path/to/your-project/vendor/autoload.php';
$api = new MangoPay\MangoPayApi();

// configuration
$api->Config->ClientId = 'your-client-id';
$api->Config->ClientPassword = 'your-client-password';
$api->Config->TemporaryFolder = '/some/path/';
//$api->Config->BaseUrl = 'https://api.mangopay.com';//uncomment this to use the production environment

//uncomment any of the following to use a custom value (these are all entirely optional)
//$api->Config->CurlResponseTimeout = 20;//The cURL response timeout in seconds (its 30 by default)
//$api->Config->CurlConnectionTimeout = 60;//The cURL connection timeout in seconds (its 80 by default)
//$api->Config->CertificatesFilePath = ''; //Absolute path to file holding one or more certificates to verify the peer with (if empty, there won't be any verification of the peer's certificate)

// call some API methods...
try {
    $users = $api->Users->GetAll();
} catch(MangoPay\Libraries\ResponseException $e) {
    // handle/log the response exception with code $e->GetCode(), message $e->GetMessage() and error(s) $e->GetErrorDetails()
} catch(MangoPay\Libraries\Exception $e) {
    // handle/log the exception $e->GetMessage()
}
```


Sample usage
-------------------------------------------------
```php
require_once '/path/to/your-project/vendor/autoload.php';
$api = new MangoPay\MangoPayApi();

// configuration
$api->Config->ClientId = 'your-client-id';
$api->Config->ClientPassword = 'your-client-password';
$api->Config->TemporaryFolder = '/some/path/';

// get some user by id
try {
    $john = $api->Users->Get($someId);
} catch(MangoPay\Libraries\ResponseException $e) {
    // handle/log the response exception with code $e->GetCode(), message $e->GetMessage() and error(s) $e->GetErrorDetails()
} catch(MangoPay\Libraries\Exception $e) {
    // handle/log the exception $e->GetMessage()
}

// change and update some of his data
$john->LastName .= " - CHANGED";
try {
    $api->Users->Update($john);
} catch(MangoPay\Libraries\ResponseException $e) {
    // handle/log the response exception with code $e->GetCode(), message $e->GetMessage() and error(s) $e->GetErrorDetails()
} catch(MangoPay\Libraries\Exception $e) {
    // handle/log the exception $e->GetMessage()
}

// get all users (with pagination)
$pagination = new MangoPay\Pagination(1, 8); // get 1st page, 8 items per page
try {
    $users = $api->Users->GetAll($pagination);
} catch(MangoPay\Libraries\ResponseException $e) {
    // handle/log the response exception with code $e->GetCode(), message $e->GetMessage() and error(s) $e->GetErrorDetails()
} catch(MangoPay\Libraries\Exception $e) {
    // handle/log the exception $e->GetMessage()
}

// get his bank accounts
$pagination = new MangoPay\Pagination(2, 10); // get 2nd page, 10 items per page
try {
    $accounts = $api->Users->GetBankAccounts($john->Id, $pagination);
} catch(MangoPay\Libraries\ResponseException $e) {
    // handle/log the response exception with code $e->GetCode(), message $e->GetMessage() and error(s) $e->GetErrorDetails()
} catch(MangoPay\Libraries\Exception $e) {
    // handle/log the exception $e->GetMessage()
}
```


Sample usage with Composer in a Symfony project
-------------------------------------------------
You can integrate Mangopay features in a Service in your Symfony project.

MangoPayService.php :
```php

<?php

namespace Path\To\Service;

use MangoPay;


class MangoPayService
{

    private $mangoPayApi;

    public function __construct()
    {
        $this->mangoPayApi = new MangoPay\MangoPayApi();
        $this->mangoPayApi->Config->ClientId = 'your-client-id';
        $this->mangoPayApi->Config->ClientPassword = 'your-client-password';
        $this->mangoPayApi->Config->TemporaryFolder = '/some/path/';
        //$this->mangoPayApi->Config->BaseUrl = 'https://api.sandbox.mangopay.com';
    }

    /**
     * Create Mangopay User
     * @return MangopPayUser $mangoUser
     */
    public function getMangoUser()
    {

        $mangoUser = new \MangoPay\UserNatural();
        $mangoUser->PersonType = "NATURAL";
        $mangoUser->FirstName = 'John';
        $mangoUser->LastName = 'Doe';
        $mangoUser->Birthday = 1409735187;
        $mangoUser->Nationality = "FR";
        $mangoUser->CountryOfResidence = "FR";
        $mangoUser->Email = 'john.doe@mail.com';

        //Send the request
        $mangoUser = $this->mangoPayApi->Users->Create($mangoUser);

        return $mangoUser;
    }
}
```


Logging
-------
MangoPay uses the PSR3 LoggerInterface. You can provide your own logger to the API.
Here is a sample showing Monolog integration :

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

...

$logger = new Logger('sample-logger');
$logger->pushHandler(new StreamHandler($logConfig['path'], Logger::DEBUG));

$this->mangoPayApi = new MangoPay\MangoPayApi();
$this->mangoPayApi->setLogger($logger);
```

Verifying rate limits status
---------------------------
According to API docs (https://docs.mangopay.com/guide/rate-limiting), MangoPay is providing a way of
verifying how many API calls were made, how many are left and when the counter will be reset.
So there are 4 groups of rate limits available:
1. Last 15 minutes:
2. Last 30 minutes
3. Last 60 minutes
4. Last 24 hours

This information is available from the MangoPayApi instance, like in the following example:

```php
<?php

namespace Path\To\Service;

use MangoPay;


class MangoPayService
{

    /**
    * @var MangoPay\MangoPayApi
    */
    private $mangoPayApi;

    public function __construct()
    {
        $this->mangoPayApi = new MangoPay\MangoPayApi();
        $this->mangoPayApi->Config->ClientId = 'your-client-id';
        $this->mangoPayApi->Config->ClientPassword = 'your-client-password';
        $this->mangoPayApi->Config->TemporaryFolder = '/some/path/';
        //$this->mangoPayApi->Config->BaseUrl = 'https://api.sandbox.mangopay.com';
    }

    public function verifyRateLimits()
    {
        // This is an array of 4 RateLimit objects.
        $rateLimits = $this->mangoPayApi->RateLimits;
        print "\nThere were " . $rateLimits[0]->CallsMade . " calls made in the last 15 minutes";
        print "\nYou can do " . $rateLimits[0]->CallsRemaining . " more calls in the next 15 minutes";
        print "\nThe 60 minutes counter will reset at " . date("Y-m-d\TH:i:s\Z", $rateLimits[0]->ResetTimeTimestamp);
        print "\nThere were " . $rateLimits[2]->CallsMade . " calls made in the last 60 minutes";
        print "\nYou can do " . $rateLimits[2]->CallsRemaining . " more calls in the next 60 minutes";
        print "\nThe 60 minutes counter will reset at " . date("Y-m-d\TH:i:s\Z", $rateLimits[2]->ResetTimeTimestamp);
    }
}

```
