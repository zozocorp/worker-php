<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Route;

use Worker\Model\Route\ShowResponse;
use Worker\Tests\Model\BaseModelTest;

class ShowResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "route": {
      "description": "Sample route",
      "created_at": "Wed, 15 Feb 2012 13:03:31 GMT",
      "actions": [
          "forward(\"http://myhost.com/messages/\")",
          "stop()"
      ],
      "priority": 0,
      "expression": "match_recipient(\".*@samples.worker.org\")",
      "id": "4f3bad2335335426750048c6"
  }
}
JSON;
        $model = ShowResponse::create(json_decode($json, true));
        $this->assertEquals('Sample route', $model->getRoute()->getDescription());
    }
}
