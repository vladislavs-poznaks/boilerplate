<?php

declare(strict_types=1);

namespace App\Http;

class Response
{
    public static function json(array $data = [], HttpCode $httpCode = HttpCode::OK): string
    {
        http_response_code($httpCode->value);

        return json_encode($data);
    }
}
