<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\MailingList\Member;

use Worker\Model\MailingList\Member\Member;
use Worker\Model\MailingList\Member\UpdateResponse;
use Worker\Tests\Model\BaseModelTest;

class UpdateResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "member": {
      "vars": {
          "age": 26
      },
      "name": "Foo Bar",
      "subscribed": false,
      "address": "bar@example.com"
  },
  "message": "Mailing list member has been updated"
}
JSON;
        $model = UpdateResponse::create(json_decode($json, true));
        $this->assertEquals('Mailing list member has been updated', $model->getMessage());
        $this->assertInstanceOf(Member::class, $model->getMember());
        $this->assertEquals('Foo Bar', $model->getMember()->getName());
    }
}
