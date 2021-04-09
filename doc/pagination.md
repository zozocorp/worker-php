# Pagination

Some API endpoints do support pagination. 

```php

/** @var Worker\Model\Tag\IndexReponse $response */
$response = $worker->tags()->index('example.com');

// Parse through the first response
// ...

$nextResponse = $worker->tags()->nextPage($response);
$previousResponse = $worker->tags()->previousPage($response);
$firstResponse = $worker->tags()->firstPage($response);
$lastResponse = $worker->tags()->lastPage($response);
```
