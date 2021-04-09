<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\MailingList;

use Worker\Model\MailingList\ValidateResponse;
use Worker\Tests\Model\BaseModelTest;

class ValidateResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
    "id": "listname@yourdomain.com",
    "message": "The validation job was submitted."
}
JSON;
        $model = ValidateResponse::create(json_decode($json, true));
        $this->assertEquals('The validation job was submitted.', $model->getMessage());
        $this->assertEquals('listname@yourdomain.com', $model->getId());
    }
}
