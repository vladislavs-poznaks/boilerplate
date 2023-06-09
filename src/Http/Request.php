<?php

declare(strict_types=1);

namespace App\Http;

use App\Dto\Dto;
use App\Exceptions\Http\ValidationException;
use Valitron\Validator;

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

    protected Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator($this->all());

        $this->validator->rules($this->rules());

        if (! $this->validator->validate()) {
            throw new ValidationException($this);
        }
    }

    public function all(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function dto(): Dto
    {
        return new Dto();
    }

    public function rules(): array
    {
        return [
            // Validation rules
        ];
    }

    public function getBearerToken(): ?string
    {
        $headers = null;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    public function getHttpErrorCode(): HttpCode
    {
        return HttpCode::BAD_REQUEST;
    }

    public function errors(?string $field = null): array|bool
    {
        return $this->validator->errors($field);
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
