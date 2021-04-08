<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Model\Domain;

use Worker\Model\ApiResponse;

/**
 * @author Artem Bondarenko <artem@uartema.com>
 */
final class UpdateUnsubscribeTrackingResponse implements ApiResponse
{
    private $message;
    private $unsubscribe;

    public static function create(array $data): self
    {
        $model = new self();
        $model->message = $data['message'] ?? null;
        $model->unsubscribe = UnsubscribeTracking::create($data['unsubscribe'] ?? []);

        return $model;
    }

    private function __construct()
    {
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getUnsubscribe(): UnsubscribeTracking
    {
        return $this->unsubscribe;
    }
}