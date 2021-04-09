<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Event;

use Worker\Model\Event\EventResponse;
use Worker\Tests\Model\BaseModelTest;

class EventResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
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
      "log-level": "info",
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
        "https://api.worker.net/v3/samples.worker.org/events/W3siY",
    "previous":
        "https://api.worker.net/v3/samples.worker.org/events/Lkawm"
  }
}
JSON;
        $model = EventResponse::create(json_decode($json, true));
        $events = $model->getItems();
        $this->assertCount(1, $events);
        $event = $events[0];
        $this->assertEquals('czsjqFATSlC3QtAK-C80nw', $event->getId());
        $this->assertEquals('info', $event->getLogLevel());
    }
}
