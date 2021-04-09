<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Suppression\Whitelists;

use Worker\Model\Suppression\Whitelist\DeleteAllResponse;
use Worker\Tests\Model\BaseModelTest;

class DeleteAllResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
            <<<'JSON'
{
    "message": "Whitelist addresses/domains for this domain have been removed"
}
JSON;

        $model = DeleteAllResponse::create(json_decode($json, true));
        $this->assertEquals('Whitelist addresses/domains for this domain have been removed', $model->getMessage());
    }
}
