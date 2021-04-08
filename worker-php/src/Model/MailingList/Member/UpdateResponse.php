<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Model\MailingList\Member;

use Worker\Model\ApiResponse;

final class UpdateResponse implements ApiResponse
{
    private $member;
    private $message;

    public static function create(array $data): self
    {
        $model = new self();
        $model->member = Member::create($data['member']);
        $model->message = $data['message'] ?? '';

        return $model;
    }

    private function __construct()
    {
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
