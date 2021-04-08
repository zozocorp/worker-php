<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Api;

use Worker\Assert;
use Worker\Model\Event\EventResponse;

/**
 * @see https://documentation.worker.com/en/latest/api-events.html
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Event extends HttpApi
{
    use Pagination;

    /**
     * @return EventResponse
     */
    public function get(string $domain, array $params = [])
    {
        Assert::stringNotEmpty($domain);

        if (array_key_exists('limit', $params)) {
            Assert::range($params['limit'], 1, 300);
        }

        $response = $this->httpGet(sprintf('/v3/%s/events', $domain), $params);

        return $this->hydrateResponse($response, EventResponse::class);
    }
}
