<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\DnsRecord;
use Worker\Tests\Model\BaseModelTest;

class DnsRecordTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "record_type": "TXT",
  "valid": "valid",
  "name": "example.com",
  "value": "v=spf1 include:worker.org ~all"
}
JSON;
        $model = DnsRecord::create(json_decode($json, true));
        $this->assertNotEmpty($model->getType());
        $this->assertNotEmpty($model->getValidity());
        $this->assertTrue($model->isValid());
        $this->assertNotEmpty($model->getName());
        $this->assertNotEmpty($model->getValue());
    }
}
