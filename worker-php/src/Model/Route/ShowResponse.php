<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Model\Route;

use Worker\Model\ApiResponse;

/**
 * @author David Garcia <me@davidgarcia.cat>
 */
final class ShowResponse implements ApiResponse
{
    private $route;

    public static function create(array $data): self
    {
        $model = new self();
        $model->route = isset($data['route']) ? Route::create($data['route']) : null;

        return $model;
    }

    private function __construct()
    {
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }
}
