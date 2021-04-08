<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Model\Suppression;

use Worker\Model\ApiResponse;

/**
 * Serves only as an abstract base for Suppression API code.
 *
 * @author Sean Johnson <sean@worker.com>
 */
abstract class BaseResponse implements ApiResponse
{
    private $address;
    private $message;

    final private function __construct()
    {
    }

    public static function create(array $data): self
    {
        $model = new static();
        $model->address = $data['address'] ?? '';
        $model->message = $data['message'] ?? '';

        return $model;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
