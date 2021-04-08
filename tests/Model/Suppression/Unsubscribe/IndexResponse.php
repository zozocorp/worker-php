<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Model\Suppression\Unsubscribe;

use Worker\Model\ApiResponse;
use Worker\Model\PaginationResponse;
use Worker\Model\PagingProvider;

/**
 * @author Sean Johnson <sean@worker.com>
 */
final class IndexResponse implements ApiResponse, PagingProvider
{
    use PaginationResponse;

    /**
     * Array to store a list of Unsubscribe items from
     * index response.
     *
     * @see Worker/Model/Suppression/Unsubscribe/Unsubscribe
     *
     * @var Unsubscribe[]
     */
    private $items = [];

    /**
     * Store the total number of Unsubscribe items.
     *
     * @see Worker/Model/Suppression/Unsubscribe/Unsubscribe
     *
     * @var int
     */
    private $totalCount;

    private function __construct()
    {
    }

    public static function create(array $data): self
    {
        $unsubscribes = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $unsubscribes[] = Unsubscribe::create($item);
            }
        }

        $model = new self();
        $model->items = $unsubscribes;
        $model->paging = $data['paging'];

        return $model;
    }

    /**
     * @return Unsubscribe[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotalCount(): int
    {
        if (null === $this->totalCount) {
            $this->totalCount = count($this->items);
        }

        return $this->totalCount;
    }
}
