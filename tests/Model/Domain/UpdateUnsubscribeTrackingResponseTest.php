<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\UnsubscribeTracking;
use Worker\Model\Domain\UpdateUnsubscribeTrackingResponse;
use Worker\Tests\Model\BaseModelTest;

class UpdateUnsubscribeTrackingResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
            <<<'JSON'
{
  "unsubscribe": {
    "active": true,
    "html_footer": "<b>test</b>",
    "text_footer": "test"
  },
  "message": "Domain tracking settings have been updated"
}
JSON;
        $model = UpdateUnsubscribeTrackingResponse::create(json_decode($json, true));
        $this->assertNotEmpty($model->getMessage());
        $this->assertEquals('Domain tracking settings have been updated', $model->getMessage());
        $this->assertNotEmpty($model->getUnsubscribe());
        $this->assertInstanceOf(UnsubscribeTracking::class, $model->getUnsubscribe());
        $this->assertTrue($model->getUnsubscribe()->isActive());
        $this->assertEquals('<b>test</b>', $model->getUnsubscribe()->getHtmlFooter());
        $this->assertEquals('test', $model->getUnsubscribe()->getTextFooter());
    }
}
