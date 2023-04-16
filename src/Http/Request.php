<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';

    public const ALLOWED_HTTP_METHODS = [
        'GET', 'POST', 'PUT', 'PATCH', 'DELETE',
    ];

    public function all(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function rules(): array
    {
        return [
            // Validation rules
        ];
    }

    public static function method(): string
    {
        //Method spoofing
        if (isset($_POST['_method'])) {
            return in_array($_POST['_method'], Request::ALLOWED_HTTP_METHODS)
                ? $_POST['_method']
                : $_SERVER['REQUEST_METHOD'];
        }

        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return rawurldecode($uri);
    }
}
