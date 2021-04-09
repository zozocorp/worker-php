<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\MailingList;

use Worker\Model\MailingList\CreateResponse;
use Worker\Model\MailingList\MailingList;
use Worker\Tests\Model\BaseModelTest;

class CreateResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "message": "Mailing list has been created",
  "list": {
      "created_at": "Tue, 06 Mar 2012 05:44:45 GMT",
      "address": "dev@samples.worker.org",
      "members_count": 0,
      "description": "Worker developers list",
      "name": ""
  }
}
JSON;
        $model = CreateResponse::create(json_decode($json, true));
        $this->assertEquals('Mailing list has been created', $model->getMessage());
        $this->assertInstanceOf(MailingList::class, $model->getList());
        $this->assertEquals(0, $model->getList()->getMembersCount());
    }
}
