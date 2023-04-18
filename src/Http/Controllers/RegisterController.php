<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Services\RegisterService;

class RegisterController
{
    public function register(RegisterRequest $request, RegisterService $service): string
    {
        return TokenResource::make($service->process($request->dto()));
    }
}
