<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Webhook;

use Worker\Model\Webhook\ShowResponse;
use Worker\Tests\Model\BaseModelTest;

class ShowResponseTest extends BaseModelTest
{
    public function testHook1()
    {
        $json =
<<<'JSON'
{
  "webhook": {
    "urls": [
      "http:\/\/example.com\/hook_1"
    ]
  }
}

JSON;
        $model = ShowResponse::create(json_decode($json, true));

        $this->assertContains('http://example.com/hook_1', $model->getWebhookUrls());
    }
}
