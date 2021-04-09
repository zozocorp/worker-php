<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Api;

use Worker\Api\Attachment;
use Worker\Exception\InvalidArgumentException;
use Worker\Model\Attachment\Attachment as Model;

class AttachmentTest extends TestCase
{
    protected function getApiClass()
    {
        return Attachment::class;
    }

    public function testShow()
    {
        $uri = 'https://api.worker.org/v2/domains/mydomain.com/messages/WyJhOTM2NDk1ODA3Iiw/attachments/0';
        $this->setRequestMethod('GET');
        $this->setHydrateClass(Model::class);
        $this->setRequestUri($uri);

        $api = $this->getApiInstance();
        $api->show($uri);
    }

    public function testShowWrongUri()
    {
        $api = $this->getApiInstance();
        $this->expectException(InvalidArgumentException::class);
        $api->show('https://api.worker.org/v2/domains/mydomain.com');
    }

    public function testShowNonWorkerUri()
    {
        $api = $this->getApiInstance();
        $this->expectException(InvalidArgumentException::class);
        $api->show('https://example.com/v2/domains/worker.net?x=attachments/0');
    }
}
