<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Ip;

use Worker\Model\Ip\ShowResponse;
use Worker\Tests\Model\BaseModelTest;

class ShowResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "ip": "192.161.0.1",
  "dedicated": true,
  "rdns": "luna.worker.net"
}
JSON;
        $model = ShowResponse::create(json_decode($json, true));
        $this->assertEquals('192.161.0.1', $model->getIp());
        $this->assertTrue($model->getDedicated());
        $this->assertEquals('luna.worker.net', $model->getRdns());
    }
}
