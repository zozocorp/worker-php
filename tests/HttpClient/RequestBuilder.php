<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\HttpClient;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class RequestBuilder
{
    /**
     * @var RequestFactoryInterface|null
     */
    private $requestFactory;

    /**
     * @var StreamFactoryInterface|null
     */
    private $streamFactory;

    /**
     * @var MultipartStreamBuilder
     */
    private $multipartStreamBuilder;

    /**
     * Creates a new PSR-7 request.
     *
     * @param array|string|null $body Request body. If body is an array we will send a as multipart stream request.
     *                                If array, each array *item* MUST look like:
     *                                array (
     *                                'content' => string|resource|StreamInterface,
     *                                'name'    => string,
     *                                'filename'=> string (optional)
     *                                'headers' => array (optinal) ['header-name' => 'header-value']
     *                                )
     */
    public function create(string $method, string $uri, array $headers = [], $body = null): RequestInterface
    {
        if (!is_array($body)) {
            $stream = $this->getStreamFactory()->createStream((string) $body);

            return $this->createRequest($method, $uri, $headers, $stream);
        }

        $builder = $this->getMultipartStreamBuilder();
        foreach ($body as $item) {
            $name = $item['name'];
            $content = $item['content'];
            unset($item['name']);
            unset($item['content']);

            $builder->addResource($name, $content, $item);
        }

        $multipartStream = $builder->build();
        $boundary = $builder->getBoundary();
        $builder->reset();

        $headers['Content-Type'] = 'multipart/form-data; boundary="'.$boundary.'"';

        return $this->createRequest($method, $uri, $headers, $multipartStream);
    }

    // @todo remove interface => you need more interface
    public function resfullRequest(string $method, string $uri,array $body = null, array $headers = [])
    {
        $url = $uri;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        if(is_array($headers) && $headers != null){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        switch ($method) {
            case "GET":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                break;
        }
        $response = curl_exec($curl);

        if($response == false){
            return '404: API Not found';
        }

        $data = json_decode($response);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // Check the HTTP Status code
        
        $status_code = $this->statusCode($httpCode, $curl, $data);
        return $status_code;

       
    }

    // @todo remove interface => you need more interface
    private function statusCode(int $httpCode, $curl, object $data = null)
    {
        switch ($httpCode) {
            case 200:
                $error_status = "200: Success";
                return ($data);
                break;
            case 404:
                $error_status = "404: API Not found";
                break;
            case 500:
                $error_status = "500: servers replied with an error.";
                break;
            case 502:
                $error_status = "502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
                break;
            case 503:
                $error_status = "503: service unavailable. Hopefully they'll be OK soon!";
                break;
            default:
                $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($curl);
                break;
        }
        curl_close($curl);
        echo $error_status;
        die;
    }


    private function getRequestFactory(): RequestFactoryInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    public function setRequestFactory(RequestFactoryInterface $requestFactory): self
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory;
    }

    public function setStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }

    private function getMultipartStreamBuilder(): MultipartStreamBuilder
    {
        if (null === $this->multipartStreamBuilder) {
            $this->multipartStreamBuilder = new MultipartStreamBuilder();
        }

        return $this->multipartStreamBuilder;
    }

    public function setMultipartStreamBuilder(MultipartStreamBuilder $multipartStreamBuilder): self
    {
        $this->multipartStreamBuilder = $multipartStreamBuilder;

        return $this;
    }

    private function createRequest(string $method, string $uri, array $headers, StreamInterface $stream)
    {
        $request = $this->getRequestFactory()->createRequest($method, $uri);
        $request = $request->withBody($stream);
        foreach ($headers as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        return $request;
    }
}
