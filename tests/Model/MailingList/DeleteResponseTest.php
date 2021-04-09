<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\MailingList;

use Worker\Model\MailingList\DeleteResponse;
use Worker\Tests\Model\BaseModelTest;

class DeleteResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "message": "Mailing list has been deleted",
  "address": "dev@samples.worker.org"
}
JSON;
        $model = DeleteResponse::create(json_decode($json, true));
        $this->assertEquals('Mailing list has been deleted', $model->getMessage());
        $this->assertEquals('dev@samples.worker.org', $model->getAddress());
    }
}
