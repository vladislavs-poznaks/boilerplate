<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;

class TestController
{
    public function test(Request $request)
    {
        return json_encode($request->all());
    }
}
