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
use Worker\Model\Stats\TotalResponse;

/**
 * @see https://documentation.worker.com/en/latest/api-stats.html
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Stats extends HttpApi
{
    /**
     * @return TotalResponse|array
     */
    public function total(string $domain, array $params = [])
    {
        Assert::stringNotEmpty($domain);

        $response = $this->httpGet(sprintf('/v3/%s/stats/total', rawurlencode($domain)), $params);

        return $this->hydrateResponse($response, TotalResponse::class);
    }
}
