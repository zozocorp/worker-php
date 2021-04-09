<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\MailingList\Member;

use Worker\Model\MailingList\Member\CreateResponse;
use Worker\Model\MailingList\Member\Member;
use Worker\Tests\Model\BaseModelTest;

class CreateResponseTest extends BaseModelTest
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
      "name": "Bob Bar",
      "subscribed": true,
      "address": "bar@example.com"
  },
  "message": "Mailing list member has been created"
}
JSON;
        $model = CreateResponse::create(json_decode($json, true));
        $this->assertEquals('Mailing list member has been created', $model->getMessage());
        $this->assertInstanceOf(Member::class, $model->getMember());
        $this->assertEquals('Bob Bar', $model->getMember()->getName());
    }
}
