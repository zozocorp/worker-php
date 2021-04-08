# Pagination

Some API endpoints do support pagination. 

```php

/** @var Worker\Model\Tag\IndexReponse $response */
$response = $Worker->tags()->index('example.com');

// Parse through the first response
// ...

$nextResponse = $Worker->tags()->nextPage($response);
$previousResponse = $Worker->tags()->previousPage($response);
$firstResponse = $Worker->tags()->firstPage($response);
$lastResponse = $Worker->tags()->lastPage($response);
```
