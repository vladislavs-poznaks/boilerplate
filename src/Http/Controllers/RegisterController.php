<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserRegistrationService;

class RegisterController
{
    public function register(RegisterRequest $request, UserRegistrationService $service): string
    {
        return UserResource::make($service->process($request->dto()));
    }
}
