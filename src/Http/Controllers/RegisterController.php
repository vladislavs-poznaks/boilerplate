<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Response;

class RegisterController
{
    public function register(RegisterRequest $request): string
    {
        return Response::json($request->all());
    }
}
