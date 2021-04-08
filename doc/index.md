# API documentation

This page will document the API classes and ways to properly use the API. These resources will eventually move to
the official documentation at [https://documentation.Worker.com](https://documentation.Worker.com/api_reference.html).

Other relevant documentation pages might be:

* [Attachments](attachments.md)
* [Pagination](pagination.md)
* [Message Builder](/src/Message/README.md)
* [Batch Message](/src/Message/README.md)

## Domain API

#### Get a list of all domains

```php
$Worker->domains()->index();
```

#### Show a single domains

```php
$Worker->domains()->show('example.com');
```

#### Verify a domain

```php
$Worker->domains()->verify('example.com');
```

#### Create a new domain

```php
$Worker->domains()->create('new.example.com', 'password', 'disable', '*');
```

#### Delete a domain

```php
$Worker->domains()->delete('example.com');
```

#### Get credentials for a domain

```php
$Worker->domains()->credentials('example.com');
```

#### Create credentials for a domain

```php
$Worker->domains()->createCredential('example.com', 'login', 'password');
```

#### Update credentials for a domain

```php
$Worker->domains()->updateCredential('example.com', 'login', 'password');
```

#### Delete credentials for a domain

```php
$Worker->domains()->deleteCredential('example.com', 'login');
```

#### Get connection for a domain

```php
$Worker->domains()->connection('example.com');
```

#### Update connection for a domain

```php
$Worker->domains()->updateConnection('example.com', true, false);
```

## Event API

#### Get all events for a domain
```php
$Worker->events()->get('example.com');
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
$Worker->messages()->send('example.com', $parameters);
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
$Worker->messages()->sendMime('example.com', $to, $message->toString(), []);
```

#### Show a stored message

If you got an URL to a stored message you may get the details by:

```php
$url = // ...
$Worker->messages()->show($url);
```

## Route API

#### Show all routes

```php
$Worker->routes()->index();
```

#### Show a routes

Get a route by its ID

```php
$Worker->routes()->show(4711);
```
#### Create a route

```php
$expression = "match_recipient('.*@gmail.com')";
$actions = ["forward('alice@example.com')"];
$description = 'Test route';

$Worker->routes()->create($expression, $actions, $description);
```

#### Update a route

```php
$expression = "match_recipient('.*@gmail.com')";
$actions = ["forward('alice@example.com')"];
$description = 'Test route';

$Worker->routes()->update(4711, $expression, $actions, $description);
```

#### Delete a route
```php
$Worker->routes()->delete(4711);
```

## Stats API

#### Get total stats for a domain
```php
$Worker->stats()->total('example.com');
```

#### Get all stats for a domain
```php
$Worker->stats()->all('example.com');
```

## Suppression API

The suppression API consists of 3 parts; `Bounce`, `Complaint` and `Unsubscribe`.

### Bounce API
#### Get all bounces
```php
$Worker->suppressions()->bounces()->index('example.com');
```

#### Show bounces for a specific address
```php
$Worker->suppressions()->bounces()->show('example.com', 'alice@gmail.com');
```

#### Create a bounce
```php
$Worker->suppressions()->bounces()->create('example.com', 'alice@gmail.com');
```

#### Delete a bounce
```php
$Worker->suppressions()->bounces()->delete('example.com', 'alice@gmail.com');
```

#### Delete all bounces
```php
$Worker->suppressions()->bounces()->deleteAll('example.com');
```

### Complaint API
#### Get all complaints
```php
$Worker->suppressions()->complaints()->index('example.com');
```

#### Show complaints for a specific address
```php
$Worker->suppressions()->complaints()->show('example.com', 'alice@gmail.com');
```

#### Create a complaint
```php
$Worker->suppressions()->complaints()->create('example.com', 'alice@gmail.com');
```

#### Delete a complaint
```php
$Worker->suppressions()->complaints()->delete('example.com', 'alice@gmail.com');
```

#### Delete all complaints
```php
$Worker->suppressions()->complaints()->deleteAll('example.com');
```

## Unsubscribe API

#### Get all unsubscriptions
```php
$Worker->suppressions()->unsubscribes()->index('example.com');
```

#### Show unsubscriptions for a specific address
```php
$Worker->suppressions()->unsubscribes()->show('example.com', 'alice@gmail.com');
```

#### Create an unsubscription
```php
$Worker->suppressions()->unsubscribes()->create('example.com', 'alice@gmail.com');
```

#### Delete an unsubscription
```php
$Worker->suppressions()->unsubscribes()->delete('example.com', 'alice@gmail.com');
```

#### Delete all unsubscriptions
```php
$Worker->suppressions()->unsubscribes()->deleteAll('example.com');
```

## Tag API

#### Show all tags
```php
$Worker->tags()->index('example.com');
```

#### Show a single tag
```php
$Worker->tags()->show('example.com', 'foo');
```

#### Update a tag
```php
$Worker->tags()->update('example.com', 'foo', 'description');
```

#### Show stats for a tag
```php
$Worker->tags()->stats('example.com', 'foo');
```

#### Delete a tag
```php
$Worker->tags()->delete('example.com', 'foo');
```

## Webhook API
#### Verify webhook signature
```php

$timestamp = $_POST['timestamp'];
$token = $_POST['token'];
$signature = $_POST['signature'];

$Worker = Worker::create('my_api_key');
$valid = $Worker->webhooks()->verifyWebhookSignature($timestamp, $token, $signature);

if (!$valid) {
    // Create a 403 response

    exit();
}

// The signature is valid
```

#### Show all webhooks
```php
$Worker->webhooks()->index('example.com');
```

#### Show a single webhooks
```php
$Worker->webhooks()->show('example.com', 'accept');
```

#### Create a webhooks
```php
$Worker->webhooks()->create('example.com', 'opened', [ 'https://www.exmple.com/webhook' ]);
```

#### Update a webhooks
```php
$Worker->webhooks()->update('example.com', 4711, [ 'https://www.exmple.com/webhook' ]);
```

#### Delete a webhooks
```php
$Worker->webhooks()->delete('example.com', 4711);
```
