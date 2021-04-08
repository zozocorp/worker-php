<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Api;

use Worker\Api\Suppression\Bounce;
use Worker\Api\Suppression\Complaint;
use Worker\Api\Suppression\Unsubscribe;
use Worker\Api\Suppression\Whitelist;
use Worker\HttpClient\RequestBuilder;
use Worker\Hydrator\Hydrator;
use Psr\Http\Client\ClientInterface;

/**
 * @see https://documentation.worker.com/api-suppressions.html
 *
 * @author Sean Johnson <sean@worker.com>
 */
class Suppression
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * @var Hydrator
     */
    private $hydrator;

    public function __construct(ClientInterface $httpClient, RequestBuilder $requestBuilder, Hydrator $hydrator)
    {
        $this->httpClient = $httpClient;
        $this->requestBuilder = $requestBuilder;
        $this->hydrator = $hydrator;
    }

    public function bounces(): Bounce
    {
        return new Bounce($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function complaints(): Complaint
    {
        return new Complaint($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function unsubscribes(): Unsubscribe
    {
        return new Unsubscribe($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function whitelists(): Whitelist
    {
        return new Whitelist($this->httpClient, $this->requestBuilder, $this->hydrator);
    }
}
