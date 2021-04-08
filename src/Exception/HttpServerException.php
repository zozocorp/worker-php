<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Exception;

use Worker\Exception;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class HttpServerException extends \RuntimeException implements Exception
{
    public static function serverError(int $httpStatus = 500)
    {
        return new self('An unexpected error occurred at Worker\'s servers. Try again later and contact support if the error still exists.', $httpStatus);
    }

    public static function networkError(\Throwable $previous)
    {
        return new self('Worker\'s servers are currently unreachable.', 0, $previous);
    }

    public static function unknownHttpResponseCode(int $code)
    {
        return new self(sprintf('Unknown HTTP response code ("%d") received from the API server', $code));
    }
}
