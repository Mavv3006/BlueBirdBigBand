<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class NotImplementedHttpException extends HttpException
{
    public function __construct(string $message = '', ?Throwable $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(501, $message, $previous, $headers, $code);
    }
}
