# API documentation

This page will document the API classes and ways to properly use the API. These resources will eventually move to
the official documentation at [https://documentation.worker.com](https://documentation.worker.com/api_reference.html).

Other relevant documentation pages might be:

* [Attachments](attachments.md)
* [Pagination](pagination.md)
* [Message Builder](/src/Message/README.md)
* [Batch Message](/src/Message/README.md)

## Domain API

#### Get a list of all domains

```php
$worker->domains()->index();
```

#### Show a single domains

```php
$worker->domains()->show('example.com');
```

#### Verify a domain

```php
$worker->domains()->verify('example.com');
```

#### Create a new domain

```php
$worker->domains()->create('new.example.com', 'password', 'disable', '*');
```

#### Delete a domain

```php
$worker->domains()->delete('example.com');
```

#### Get credentials for a domain

```php
$worker->domains()->credentials('example.com');
```

#### Create credentials for a domain

```php
$worker->domains()->createCredential('example.com', 'login', 'password');
```

#### Update credentials for a domain

```php
$worker->domains()->updateCredential('example.com', 'login', 'password');
```

#### Delete credentials for a domain

```php
$worker->domains()->deleteCredential('example.com', 'login');
```

#### Get connection for a domain

```php
$worker->domains()->connection('example.com');
```

#### Update connection for a domain

```php
$worker->domains()->updateConnection('example.com', true, false);
```

## Event API

#### Get all events for a domain
```php
$worker->events()->get('example.com');
```

## Message API

#### Send a message
```php
$parameters = [
    'from'    => 'bob@example.com',
    'to'      => 'sally@example.com',
    'subject' => 'The PHP SDK is awesome!',
    'text'    => 'It is so simple to send a message.'
];
$worker->messages()->send('example.com', $parameters);
```
#### Send a message with Mime

Below in an example how to create a Mime message with SwiftMailer.

```php
$message = new Swift_Message('Mail Subject');
$message->setFrom(['from@exemple.com' => 'Example Inc']);
$message->setTo(['user0gmail.com' => 'User 0', 'user1@hotmail.com' => 'User 1']);
// $message->setBcc('admin@example.com'); Do not do this, BCC will be visible for all receipients if you do.
$message->setCc('invoice@example.com');

$messageBody = 'Look at the <b>fancy</b> HTML body.';
$message->setBody($messageBody, 'text/html');

// We need all "tos". Incluce the BCC here.
$to = ['admin@example.com', 'user0gmail.com', 'user1@hotmail.com', 'invoice@example.com']

// Send the message
$worker->messages()->sendMime('example.com', $to, $message->toString(), []);
```

#### Show a stored message

If you got an URL to a stored message you may get the details by:

```php
$url = // ...
$worker->messages()->show($url);
```

## Route API

#### Show all routes

```php
$worker->routes()->index();
```

#### Show a routes

Get a route by its ID

```php
$worker->routes()->show(4711);
```
#### Create a route

```php
$expression = "match_recipient('.*@gmail.com')";
$actions = ["forward('alice@example.com')"];
$description = 'Test route';

$worker->routes()->create($expression, $actions, $description);
```

#### Update a route

```php
$expression = "match_recipient('.*@gmail.com')";
$actions = ["forward('alice@example.com')"];
$description = 'Test route';

$worker->routes()->update(4711, $expression, $actions, $description);
```

#### Delete a route
```php
$worker->routes()->delete(4711);
```

## Stats API

#### Get total stats for a domain
```php
$worker->stats()->total('example.com');
```

#### Get all stats for a domain
```php
$worker->stats()->all('example.com');
```

## Suppression API

The suppression API consists of 3 parts; `Bounce`, `Complaint` and `Unsubscribe`.

### Bounce API
#### Get all bounces
```php
$worker->suppressions()->bounces()->index('example.com');
```

#### Show bounces for a specific address
```php
$worker->suppressions()->bounces()->show('example.com', 'alice@gmail.com');
```

#### Create a bounce
```php
$worker->suppressions()->bounces()->create('example.com', 'alice@gmail.com');
```

#### Delete a bounce
```php
$worker->suppressions()->bounces()->delete('example.com', 'alice@gmail.com');
```

#### Delete all bounces
```php
$worker->suppressions()->bounces()->deleteAll('example.com');
```

### Complaint API
#### Get all complaints
```php
$worker->suppressions()->complaints()->index('example.com');
```

#### Show complaints for a specific address
```php
$worker->suppressions()->complaints()->show('example.com', 'alice@gmail.com');
```

#### Create a complaint
```php
$worker->suppressions()->complaints()->create('example.com', 'alice@gmail.com');
```

#### Delete a complaint
```php
$worker->suppressions()->complaints()->delete('example.com', 'alice@gmail.com');
```

#### Delete all complaints
```php
$worker->suppressions()->complaints()->deleteAll('example.com');
```

## Unsubscribe API

#### Get all unsubscriptions
```php
$worker->suppressions()->unsubscribes()->index('example.com');
```

#### Show unsubscriptions for a specific address
```php
$worker->suppressions()->unsubscribes()->show('example.com', 'alice@gmail.com');
```

#### Create an unsubscription
```php
$worker->suppressions()->unsubscribes()->create('example.com', 'alice@gmail.com');
```

#### Delete an unsubscription
```php
$worker->suppressions()->unsubscribes()->delete('example.com', 'alice@gmail.com');
```

#### Delete all unsubscriptions
```php
$worker->suppressions()->unsubscribes()->deleteAll('example.com');
```

## Tag API

#### Show all tags
```php
$worker->tags()->index('example.com');
```

#### Show a single tag
```php
$worker->tags()->show('example.com', 'foo');
```

#### Update a tag
```php
$worker->tags()->update('example.com', 'foo', 'description');
```

#### Show stats for a tag
```php
$worker->tags()->stats('example.com', 'foo');
```

#### Delete a tag
```php
$worker->tags()->delete('example.com', 'foo');
```

## Webhook API
#### Verify webhook signature
```php

$timestamp = $_POST['timestamp'];
$token = $_POST['token'];
$signature = $_POST['signature'];

$worker = Worker::create('my_api_key');
$valid = $worker->webhooks()->verifyWebhookSignature($timestamp, $token, $signature);

if (!$valid) {
    // Create a 403 response

    exit();
}

// The signature is valid
```

#### Show all webhooks
```php
$worker->webhooks()->index('example.com');
```

#### Show a single webhooks
```php
$worker->webhooks()->show('example.com', 'accept');
```

#### Create a webhooks
```php
$worker->webhooks()->create('example.com', 'opened', [ 'https://www.exmple.com/webhook' ]);
```

#### Update a webhooks
```php
$worker->webhooks()->update('example.com', 4711, [ 'https://www.exmple.com/webhook' ]);
```

#### Delete a webhooks
```php
$worker->webhooks()->delete('example.com', 4711);
```
