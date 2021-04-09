<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Suppression\Whitelists;

use Worker\Model\Suppression\Whitelist\ImportResponse;
use Worker\Tests\Model\BaseModelTest;

class ImportResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
            <<<'JSON'
{
    "message": "file uploaded successfully"
}
JSON;

        $model = ImportResponse::create(json_decode($json, true));
        $this->assertEquals('file uploaded successfully', $model->getMessage());
    }
}
