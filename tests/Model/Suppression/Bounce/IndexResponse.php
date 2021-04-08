<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Model\Suppression\Bounce;

use Worker\Model\ApiResponse;
use Worker\Model\PaginationResponse;
use Worker\Model\PagingProvider;

/**
 * @author Sean Johnson <sean@worker.com>
 */
final class IndexResponse implements ApiResponse, PagingProvider
{
    use PaginationResponse;

    private $items;

    private function __construct()
    {
    }

    public static function create(array $data): self
    {
        $bounces = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $bounces[] = Bounce::create($item);
            }
        }

        $model = new self();
        $model->items = $bounces;
        $model->paging = $data['paging'];

        return $model;
    }

    /**
     * @return Bounce[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}