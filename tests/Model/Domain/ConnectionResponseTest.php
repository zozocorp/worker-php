<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\ConnectionResponse;
use Worker\Tests\Model\BaseModelTest;

class ConnectionResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "connection": {
    "require_tls": false,
    "skip_verification": false
  }
}
JSON;
        $model = ConnectionResponse::create(json_decode($json, true));
        $this->assertFalse($model->getRequireTLS());
        $this->assertFalse($model->getSkipVerification());
    }
}
