<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;

class RegisterController
{
    public function register(Request $request): string
    {
        return Response::json($request->all());
    }
}
