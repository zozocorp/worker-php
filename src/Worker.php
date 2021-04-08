<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker;

use Http\Client\Common\PluginClient;
use Worker\HttpClient\HttpClientConfigurator;
use Worker\HttpClient\Plugin\History;
use Worker\HttpClient\RequestBuilder;
use Worker\Hydrator\Hydrator;
use Worker\Hydrator\ModelHydrator;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * This class is the base class for the Worker SDK.
 */
class Worker
{
    /**
     * @var string|null
     */
    private $apiKey;

    /**
     * @var ClientInterface|PluginClient
     */
    private $httpClient;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

     /**
     * @var string
     */
    private static $host = 'https://worker.zozo.vn/api/v1';

    /**
     * This is a object that holds the last response from the API.
     *
     * @var History
     */
    private $responseHistory;

    public function __construct(
        HttpClientConfigurator $configurator,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
        $this->hydrator = $hydrator ?: new ModelHydrator();

        $this->httpClient = $configurator->createConfiguredClient();
        $this->apiKey = $configurator->getApiKey();
        $this->responseHistory = $configurator->getResponseHistory();
        $this->httpClient->apiKey = $configurator->getApiKey();
        $this->httpClient->host = self::$host;
    }

    public static function create(string $apiKey, string $endpoint = 'https://worker.zozo.vn/api/v1'): self
    {
        $httpClientConfigurator = (new HttpClientConfigurator())
            ->setApiKey($apiKey);
        return new self($httpClientConfigurator);
    }

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->responseHistory->getLastResponse();
    }

    public function attachment(): Api\Attachment
    {
        return new Api\Attachment($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function verifyEmail(): Api\VerifyEmail
    {
        return new Api\VerifyEmail($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function emailValidation(): Api\EmailValidation
    {
        return new Api\EmailValidation($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function events(): Api\Event
    {
        return new Api\Event($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function ips(): Api\Ip
    {
        return new Api\Ip($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function mailingList(): Api\MailingList
    {
        return new Api\MailingList($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function messages(): Api\Message
    {
        return new Api\Message($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function routes(): Api\Route
    {
        return new Api\Route($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function suppressions(): Api\Suppression
    {
        return new Api\Suppression($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function stats(): Api\Stats
    {
        return new Api\Stats($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function tags(): Api\Tag
    {
        return new Api\Tag($this->httpClient, $this->requestBuilder, $this->hydrator);
    }

    public function webhooks(): Api\Webhook
    {
        return new Api\Webhook($this->httpClient, $this->requestBuilder, $this->hydrator, $this->apiKey);
    }
}
