<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\CredentialResponseItem;
use Worker\Tests\Model\BaseModelTest;

class CredentialResponseItemTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "size_bytes": 5,
  "created_at": "Tue, 27 Sep 2011 20:24:22 GMT",
  "mailbox": "user@samples.worker.org",
  "login": "user"
}
JSON;
        $model = CredentialResponseItem::create(json_decode($json, true));
        $this->assertEquals('user', $model->getLogin());
        $this->assertEquals('user@samples.worker.org', $model->getMailbox());
        $this->assertEquals('5', $model->getSizeBytes());
        $this->assertEquals(new \DateTime('Tue, 27 Sep 2011 20:24:22 GMT'), $model->getCreatedAt());
    }
}
