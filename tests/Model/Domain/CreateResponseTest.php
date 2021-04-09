<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Domain;

use Worker\Model\Domain\CreateResponse;
use Worker\Tests\Model\BaseModelTest;

class CreateResponseTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
<<<'JSON'
{
  "domain": {
    "name": "example.com",
    "created_at": "Fri, 22 Nov 2013 18:42:33 GMT",
    "wildcard": false,
    "spam_action": "disabled",
    "smtp_login": "postmaster@example.com",
    "smtp_password": "thiswontwork",
    "state": "active"
  },
  "receiving_dns_records": [
    {
      "priority": "10",
      "record_type": "MX",
      "valid": "valid",
      "value": "mxa.worker.org"
    },
    {
      "priority": "10",
      "record_type": "MX",
      "valid": "valid",
      "value": "mxb.worker.org"
    }
  ],
  "message": "Domain has been created",
  "sending_dns_records": [
    {
      "record_type": "TXT",
      "valid": "valid",
      "name": "example.com",
      "value": "v=spf1 include:worker.org ~all"
    },
    {
      "record_type": "TXT",
      "valid": "valid",
      "name": "k1._domainkey.example.com",
      "value": "k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4G...."
    },
    {
      "record_type": "CNAME",
      "valid": "valid",
      "name": "email.example.com",
      "value": "worker.org"
    }
  ]
}

JSON;
        $model = CreateResponse::create(json_decode($json, true));
        $this->assertNotEmpty($model->getMessage());
        $this->assertNotEmpty($model->getDomain());
        $this->assertNotEmpty($model->getInboundDNSRecords());
        $this->assertNotEmpty($model->getOutboundDNSRecords());
    }
}
