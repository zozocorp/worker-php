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
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Attachment extends HttpApi
{
    /**
     * @return ResponseInterface
     */
    public function show(string $url)
    {
        Assert::stringNotEmpty($url);
        Assert::regex($url, '@https://.*worker\.(net|org)/v.+@');
        Assert::regex($url, '|/attachments/[0-9]+|');

        $response = $this->httpGet($url);

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $response;
    }
}
