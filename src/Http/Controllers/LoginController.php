<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\Services\LoginServiceException;
use App\Http\HttpCode;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Http\Response;
use App\Services\LoginService;

class LoginController
{
    public function login(LoginRequest $request, LoginService $service): string
    {
        try {
            $token = $service->process($request->dto());

            return TokenResource::make($token);
        } catch (LoginServiceException $exception) {

            return Response::json([
                'message' => $exception->getMessage()
            ], HttpCode::UNAUTHORIZED);
        }
    }
}
