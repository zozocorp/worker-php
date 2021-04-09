<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\IndexResponse;
use Worker\Tests\Model\BaseModelTest;

class IndexResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "total_count": 1,
  "items": [
    {
      "created_at": "Wed, 10 Jul 2013 19:26:52 GMT",
      "smtp_login": "postmaster@samples.worker.org",
      "name": "samples.worker.org",
      "smtp_password": "4rtqo4p6rrx9",
      "wildcard": true,
      "spam_action": "disabled",
      "state": "active"
    }
  ]
}

JSON;
        $model = IndexResponse::create(json_decode($json, true));
        $this->assertEquals(1, $model->getTotalCount());
        $this->assertCount(1, $model->getDomains());
    }
}
