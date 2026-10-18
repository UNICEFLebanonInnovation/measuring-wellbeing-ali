<?php

namespace App\Http\Requests;

class PreTestRequest extends TestRequest
{
    protected function isPostTest(): bool
    {
        return false;
    }
}
