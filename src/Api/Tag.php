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
use Worker\Model\Tag\CountryResponse;
use Worker\Model\Tag\DeleteResponse;
use Worker\Model\Tag\DeviceResponse;
use Worker\Model\Tag\IndexResponse;
use Worker\Model\Tag\ProviderResponse;
use Worker\Model\Tag\ShowResponse;
use Worker\Model\Tag\StatisticsResponse;
use Worker\Model\Tag\UpdateResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @see https://documentation.worker.com/en/latest/api-tags.html
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Tag extends HttpApi
{
    use Pagination;

    /**
     * Returns a list of tags.

     *
     * @return IndexResponse|ResponseInterface
     */
    public function index(string $domain, int $limit = 100)
    {
        Assert::stringNotEmpty($domain);
        Assert::range($limit, 1, 1000);

        $params = [
            'limit' => $limit,
        ];

        $response = $this->httpGet(sprintf('/v3/%s/tags', $domain), $params);

        return $this->hydrateResponse($response, IndexResponse::class);
    }

    /**
     * Returns a single tag.
     *
     * @return ShowResponse|ResponseInterface
     */
    public function show(string $domain, string $tag)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($tag);

        $response = $this->httpGet(sprintf('/v3/%s/tags/%s', $domain, $tag));

        return $this->hydrateResponse($response, ShowResponse::class);
    }

    /**
     * Update a tag.
     *
     * @return UpdateResponse|ResponseInterface
     */
    public function update(string $domain, string $tag, string $description)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($tag);

        $params = [
            'description' => $description,
        ];

        $response = $this->httpPut(sprintf('/v3/%s/tags/%s', $domain, $tag), $params);

        return $this->hydrateResponse($response, UpdateResponse::class);
    }

    /**
     * Returns statistics for a single tag.
     *
     * @return StatisticsResponse|ResponseInterface
     */
    public function stats(string $domain, string $tag, array $params)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($tag);

        $response = $this->httpGet(sprintf('/v3/%s/tags/%s/stats', $domain, $tag), $params);

        return $this->hydrateResponse($response, StatisticsResponse::class);
    }

    /**
     * Removes a tag from the account.
     *
     * @return DeleteResponse|ResponseInterface
     */
    public function delete(string $domain, string $tag)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($tag);

        $response = $this->httpDelete(sprintf('/v3/%s/tags/%s', $domain, $tag));

        return $this->hydrateResponse($response, DeleteResponse::class);
    }

    /**
     * @return CountryResponse|ResponseInterface
     */
    public function countries(string $domain, string $tag)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($tag);

        $response = $this->httpGet(sprintf('/v3/%s/tags/%s/stats/aggregates/countries', $domain, $tag));

        return $this->hydrateResponse($response, CountryResponse::class);
    }

    /**
     * @return ProviderResponse|ResponseInterface
     */
    public function providers(string $domain, string $tag)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($tag);

        $response = $this->httpGet(sprintf('/v3/%s/tags/%s/stats/aggregates/providers', $domain, $tag));

        return $this->hydrateResponse($response, ProviderResponse::class);
    }

    /**
     * @return DeviceResponse|ResponseInterface
     */
    public function devices(string $domain, string $tag)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($tag);

        $response = $this->httpGet(sprintf('/v3/%s/tags/%s/stats/aggregates/devices', $domain, $tag));

        return $this->hydrateResponse($response, DeviceResponse::class);
    }
}
