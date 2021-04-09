<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Api;

use GuzzleHttp\Psr7\Response;
use Worker\Api\Event;
use Worker\Exception\InvalidArgumentException;
use Worker\Model\Event\EventResponse;

class EventTest extends TestCase
{
    protected function getApiClass()
    {
        return Event::class;
    }

    public function testGet()
    {
        $this->setRequestMethod('GET');
        $this->setRequestUri('/v3/example.com/events');
        $this->setHttpResponse(new Response(200, ['Content-Type' => 'application/json'], <<<'JSON'
{
  "items": [
    {
      "tags": [],
      "id": "czsjqFATSlC3QtAK-C80nw",
      "timestamp": 1376325780.160809,
      "envelope": {
        "sender": "me@samples.worker.org",
        "transport": ""
      },
      "event": "accepted",
      "campaigns": [],
      "user-variables": {},
      "flags": {
        "is-authenticated": true,
        "is-test-mode": false
      },
      "message": {
        "headers": {
          "to": "foo@example.com",
          "message-id": "20130812164300.28108.52546@samples.worker.org",
          "from": "Excited User <me@samples.worker.org>",
          "subject": "Hello"
        },
        "attachments": [],
        "recipients": [
          "foo@example.com",
          "baz@example.com",
          "bar@example.com"
        ],
        "size": 69
      },
      "recipient": "baz@example.com",
      "method": "http"
    }
  ],
  "paging": {
    "next":
        "https://api.worker.net/v3/samples.worker.org/events/W3siY...",
    "previous":
        "https://api.worker.net/v3/samples.worker.org/events/Lkawm..."
  }
}
JSON
));

        $api = $this->getApiInstance();
        $event = $api->get('example.com');
        $this->assertInstanceOf(EventResponse::class, $event);
        $this->assertCount(1, $event->getItems());
        $this->assertEquals('accepted', $event->getItems()[0]->getEvent());
    }

    public function testGetWithEmptyDomain()
    {
        $api = $this->getApiMock();
        $this->expectException(InvalidArgumentException::class);
        $api->get('');
    }
}
