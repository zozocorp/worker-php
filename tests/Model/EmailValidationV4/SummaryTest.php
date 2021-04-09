<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Event;

use Worker\Model\EmailValidationV4\Summary;
use Worker\Model\EmailValidationV4\SummaryResult;
use Worker\Model\EmailValidationV4\SummaryRisk;
use Worker\Tests\Model\BaseModelTest;

class SummaryTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
            <<<'JSON'
{
    "result": {
        "deliverable": 181854,
        "do_not_send": 5647,
        "undeliverable": 12116,
        "catch_all" : 2345,
        "unknown": 5613
    },
    "risk": {
        "high": 17763,
        "low": 142547,
        "medium": 41652,
        "unknown": 5613
    }
}
JSON;
        $model = Summary::create(json_decode($json, true));
        $this->assertInstanceOf(SummaryResult::class, $model->getResult());
        $this->assertInstanceOf(SummaryRisk::class, $model->getRisk());
    }
}
