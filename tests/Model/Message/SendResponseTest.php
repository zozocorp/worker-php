<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Message;

use Worker\Model\Message\SendResponse;
use Worker\Tests\Model\BaseModelTest;

class SendResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "message": "Queued. Thank you.",
  "id": "<20111114174239.25659.5817@samples.worker.org>"
}
JSON;
        $model = SendResponse::create(json_decode($json, true));
        $this->assertEquals('<20111114174239.25659.5817@samples.worker.org>', $model->getId());
        $this->assertEquals('Queued. Thank you.', $model->getMessage());
    }
}
