<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Api\Suppression;

use Worker\Api\HttpApi;
use Worker\Api\Pagination;
use Worker\Assert;
use Worker\Model\Suppression\Unsubscribe\CreateResponse;
use Worker\Model\Suppression\Unsubscribe\DeleteResponse;
use Worker\Model\Suppression\Unsubscribe\IndexResponse;
use Worker\Model\Suppression\Unsubscribe\ShowResponse;

/**
 * @see https://documentation.worker.com/api-suppressions.html#unsubscribes
 *
 * @author Sean Johnson <sean@worker.com>
 */
class Unsubscribe extends HttpApi
{
    use Pagination;

    /**
     * @param string $domain Domain to get unsubscribes for
     * @param int    $limit  optional
     *
     * @return IndexResponse
     */
    public function index(string $domain, int $limit = 100)
    {
        Assert::stringNotEmpty($domain);
        Assert::range($limit, 1, 10000, 'Limit parameter must be between 1 and 10000');

        $params = [
            'limit' => $limit,
        ];

        $response = $this->httpGet(sprintf('/v3/%s/unsubscribes', $domain), $params);

        return $this->hydrateResponse($response, IndexResponse::class);
    }

    /**
     * @param string $domain  Domain to show unsubscribe for
     * @param string $address Unsubscribe address
     *
     * @return ShowResponse
     */
    public function show(string $domain, string $address)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($address);

        $response = $this->httpGet(sprintf('/v3/%s/unsubscribes/%s', $domain, $address));

        return $this->hydrateResponse($response, ShowResponse::class);
    }

    /**
     * @param string $domain  Domain to create unsubscribe for
     * @param string $address Unsubscribe address
     * @param array  $params  optional
     *
     * @return CreateResponse
     */
    public function create(string $domain, string $address, array $params = [])
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($address);

        $params['address'] = $address;

        $response = $this->httpPost(sprintf('/v3/%s/unsubscribes', $domain), $params);

        return $this->hydrateResponse($response, CreateResponse::class);
    }

    /**
     * @param string      $domain  Domain to delete unsubscribe for
     * @param string      $address Unsubscribe address
     * @param string|null $tag     Unsubscribe tag
     *
     * @return DeleteResponse
     */
    public function delete(string $domain, string $address, string $tag = null)
    {
        Assert::stringNotEmpty($domain);
        Assert::stringNotEmpty($address);
        Assert::nullOrStringNotEmpty($tag);

        $params = [];
        if (!is_null($tag)) {
            $params['tag'] = $tag;
        }

        $response = $this->httpDelete(sprintf('/v3/%s/unsubscribes/%s', $domain, $address), $params);

        return $this->hydrateResponse($response, DeleteResponse::class);
    }

    /**
     * @param string $domain Domain to delete all unsubscribes for
     *
     * @return DeleteResponse
     */
    public function deleteAll(string $domain)
    {
        Assert::stringNotEmpty($domain);

        $response = $this->httpDelete(sprintf('/v3/%s/unsubscribes', $domain));

        return $this->hydrateResponse($response, DeleteResponse::class);
    }
}
