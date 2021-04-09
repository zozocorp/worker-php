<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\MailingList;

use Worker\Model\MailingList\ValidationStatusDownloadUrl;
use Worker\Tests\Model\BaseModelTest;

class ValidationStatusDownloadUrlTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
            <<<'JSON'
{
    "csv": "http://example.com/filname.csv",
    "json": "http://example.com/filname.json"
}
JSON;
        $model = ValidationStatusDownloadUrl::create(json_decode($json, true));
        $this->assertEquals('http://example.com/filname.csv', $model->getCsv());
        $this->assertEquals('http://example.com/filname.json', $model->getJson());
    }
}
