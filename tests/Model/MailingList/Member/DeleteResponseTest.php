<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\MailingList\Member;

use Worker\Model\MailingList\Member\DeleteResponse;
use Worker\Model\MailingList\Member\Member;
use Worker\Tests\Model\BaseModelTest;

class DeleteResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "member": {
      "address": "bar@example.com"
  },
  "message": "Mailing list member has been deleted"
}
JSON;
        $model = DeleteResponse::create(json_decode($json, true));
        $this->assertEquals('Mailing list member has been deleted', $model->getMessage());
        $member = $model->getMember();
        $this->assertInstanceOf(Member::class, $member);
        $this->assertEquals('bar@example.com', $member->getAddress());
    }
}
