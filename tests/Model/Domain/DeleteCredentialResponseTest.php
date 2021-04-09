<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\DeleteCredentialResponse;
use Worker\Tests\Model\BaseModelTest;

class DeleteCredentialResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "message": "Credentials have been deleted",
  "spec": "alice@samples.worker.org"
}

JSON;
        $model = DeleteCredentialResponse::create(json_decode($json, true));
        $this->assertNotEmpty($model->getMessage());
        $this->assertEmpty($model->getError());
        $this->assertNotEmpty($model->getSpec());
    }
}
