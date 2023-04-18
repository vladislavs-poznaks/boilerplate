<?php

declare(strict_types=1);

namespace App\Exceptions\Http;

use App\Http\Request;
use Exception;

class ValidationException extends Exception
{
    public function __construct(public Request $request)
    {
        parent::__construct();
    }
}
