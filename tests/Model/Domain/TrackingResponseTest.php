<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\ClickTracking;
use Worker\Model\Domain\OpenTracking;
use Worker\Model\Domain\TrackingResponse;
use Worker\Model\Domain\UnsubscribeTracking;
use Worker\Tests\Model\BaseModelTest;

class TrackingResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
            <<<'JSON'
{
    "tracking": {
        "click": {
            "active": "htmlonly"
        },
        "open": {
            "active": false
        },
        "unsubscribe": {
            "active": false,
            "html_footer": "<s>Test<\/s>",
            "text_footer": "Test"
        }
    }
}
JSON;
        $model = TrackingResponse::create(json_decode($json, true));
        $this->assertNotEmpty($model->getClick());
        $this->assertInstanceOf(ClickTracking::class, $model->getClick());
        $this->assertEquals('htmlonly', $model->getClick()->getActive());
        $this->assertFalse($model->getClick()->isActive());
        $this->assertTrue($model->getClick()->isHtmlOnly());

        $this->assertNotEmpty($model->getOpen());
        $this->assertInstanceOf(OpenTracking::class, $model->getOpen());
        $this->assertEquals('no', $model->getOpen()->getActive());
        $this->assertFalse($model->getOpen()->isActive());

        $this->assertNotEmpty($model->getUnsubscribe());
        $this->assertInstanceOf(UnsubscribeTracking::class, $model->getUnsubscribe());
        $this->assertEquals('no', $model->getUnsubscribe()->getActive());
        $this->assertFalse($model->getUnsubscribe()->isActive());
        $this->assertEquals('<s>Test</s>', $model->getUnsubscribe()->getHtmlFooter());
        $this->assertEquals('Test', $model->getUnsubscribe()->getTextFooter());
    }
}
