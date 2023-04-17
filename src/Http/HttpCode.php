<?php

declare(strict_types=1);

namespace App\Http;

enum HttpCode: int
{
    case OK = 200;

    case CREATED = 201;

    case BAD_REQUEST = 400;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;

    case INTERNAL_ERROR = 500;
}
