# Worker PHP client

This is the Worker PHP SDK. This SDK contains methods for easily interacting
with the Worker API. Below are examples to get you started. For additional
examples, please see our official documentation at http://documentation.worker.com

[![Latest Version](https://img.shields.io/github/release/worker/worker-php.svg?style=flat-square)](https://github.com/worker/worker-php/releases)
[![Build Status](https://img.shields.io/travis/worker/worker-php/master.svg?style=flat-square)](https://travis-ci.org/worker/worker-php)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/worker/worker-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/worker/worker-php)
[![Quality Score](https://img.shields.io/scrutinizer/g/worker/worker-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/worker/worker-php)
[![Total Downloads](https://img.shields.io/packagist/dt/worker/worker-php.svg?style=flat-square)](https://packagist.org/packages/worker/worker-php)
[![Join the chat at https://gitter.im/worker/worker-php](https://badges.gitter.im/worker/worker-php.svg)](https://gitter.im/worker/worker-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Installation

To install the SDK, you will need to be using [Composer](http://getcomposer.org/) 
in your project. 
If you aren't using Composer yet, it's really simple! Here's how to install 
composer:

```bash
curl -sS https://getcomposer.org/installer | php
```

The Worker API Client is not hard coupled to Guzzle, Buzz or any other library that sends
HTTP messages. Instead, it uses the [PSR-18](https://www.php-fig.org/psr/psr-18/) client abstraction.
This will give you the flexibility to choose what
[PSR-7 implementation and HTTP client](https://packagist.org/providers/php-http/client-implementation)
you want to use. 

If you just want to get started quickly you should run the following command: 

```bash
composer require worker/worker-php kriswallsmith/buzz nyholm/psr7
```

## Usage

You should always use Composer autoloader in your application to automatically load
your dependencies. All the examples below assume you've already included this in your
file:

```php
require 'vendor/autoload.php';
use Worker\Worker;
```

Here's how to send a message using the SDK:

```php
// First, instantiate the SDK with your API credentials
$mg = Mailgun::create('RVOuocDhKgJY6KXYFomL8kPEuiamZfo8w0XogQsQpCloNBxk1Kl7m0Gfygdy'); 
$res = $mg->messages()->send([
    "fromName" => "Zozo EMA",
    "fromEmail"=> "ledinhthi2909@gmail.com",
    "to"=> "thild@zozo.vn",
    "cc"=> "thildph07746@fpt.edu.vn",
    "template"=> "zozo_send_contact",
    "bcc"=> "",
    "contentType"=> "text",
    "content"=> "xin chào tôi là \n tôi năm nay \n gửi email thành công \n email by le thi ",
    "subject"=> "Liên hệ từ tieudv 1",
    "params"=> "",
    "merchantId" => 0,
    "merchantName" => "Zozo EMA"
]);
```

Attention: `$domain` must match to the domain you have configured on [app.worker.com](https://app.worker.com/app/domains).

### All usage examples

You will find more detailed documentation at [/doc](doc/index.md) and on 
[https://documentation.worker.com](https://documentation.worker.com/en/latest/api_reference.html).

### Response

The result of an API call is, by default, a domain object. This will make it easy
to understand the response without reading the documentation. One can just read the
doc blocks on the response classes. This provides an excellent IDE integration.
 
```php
$mg = Worker::create('key-example');
$dns = $mg->domains()->show('example.com')->getInboundDNSRecords();

foreach ($dns as $record) {
  echo $record->getType();
}
```

If you'd rather work with an array than an object you can inject the `ArrayHydrator`
to the Worker class. 

```php
$mg = Mailgun::create('RVOuocDhKgJY6KXYFomL8kPEuiamZfo8w0XogQsQpCloNBxk1Kl7m0Gfygdy'); 
$dns = $mg->verifyEmail()->show('email_address');
```

You can also use the `NoopHydrator` to get a PSR7 Response returned from 
the API calls. 

**Warning: When using `NoopHydrator` there will be no exceptions on a non-200 response.**

### Debugging

Debugging the PHP SDK can be helpful when things aren't working quite right. 
To debug the SDK, here are some suggestions: 

Set the endpoint to Worker's Postbin. A Postbin is a web service that allows you to
post data, which then you can display it through a browser. Using Postbin is an easy way
to quickly determine what data you're transmitting to Worker's API.

**Step 1 - Create a new Postbin.**  
Go to http://bin.worker.net. The Postbin will generate a special URL. Save that URL. 

**Step 2 - Instantiate the Worker client using Postbin.**  

*Tip: The bin id will be the URL part after bin.worker.net. It will be random generated letters and numbers. 
For example, the bin id in this URL (http://bin.worker.net/aecf68de) is `aecf68de`.*

```php
use Worker\HttpClient\HttpClientConfigurator;
use Worker\Hydrator\NoopHydrator;

$configurator = new HttpClientConfigurator();
$configurator->setEndpoint('http://bin.worker.net/aecf68de');
$configurator->setApiKey('key-example');
$configurator->setDebug(true);

$mg = new Worker($configurator, new NoopHydrator());

# Now, compose and send your message.
$mg->messages()->send('example.com', [
  'from'    => 'bob@example.com', 
  'to'      => 'sally@example.com', 
  'subject' => 'The PHP SDK is awesome!', 
  'text'    => 'It is so simple to send a message.'
]);
```
### Additional Info

For usage examples on each API endpoint, head over to our official documentation 
pages. 

This SDK includes a [Message Builder](src/Worker/Messages/README.md), 
[Batch Message](src/Worker/Messages/README.md) and [Opt-In Handler](src/Worker/Lists/README.md) component.

Message Builder allows you to quickly create the array of parameters, required 
to send a message, by calling a methods for each parameter.
Batch Message is an extension of Message Builder, and allows you to easily send 
a batch message job within a few seconds. The complexity of 
batch messaging is eliminated! 

## Framework integration

If you are using a framework you might consider these composer packages to make the framework integration easier. 

* [tehplague/swiftmailer-worker-bundle](https://github.com/tehplague/swiftmailer-worker-bundle) for Symfony
* [katanyoo/yii2-worker-mailer](https://github.com/katanyoo/yii2-worker-mailer) for Yii2
* [narendravaghela/cakephp-worker](https://github.com/narendravaghela/cakephp-worker) for CakePHP
* [drupal/worker](https://www.drupal.org/project/worker) for Drupal

## Contribute

This SDK is an Open Source under the MIT license. It is, thus, maintained by collaborators and contributors.

Feel free to contribute in any way. As an example you may: 
* Trying out the `dev-master` code
* Create issues if you find problems
* Reply to other people's issues
* Review PRs

### Running the test code

If you want to run the tests you should run the following commands: 

```terminal
git clone git@github.com:worker/worker-php.git
cd worker-php
composer update
composer test
```

## Support and Feedback

Be sure to visit the Worker official 
[documentation website](http://documentation.worker.com/) for additional 
information about our API. 

If you find a bug, please submit the issue in Github directly. 
[Worker-PHP Issues](https://github.com/worker/worker-php/issues)

As always, if you need additional assistance, drop us a note through your account at
[https://app.worker.com/app/support/list](https://app.worker.com/app/support/list).
