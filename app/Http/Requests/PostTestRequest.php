<?php

namespace App\Http\Requests;

class PostTestRequest extends TestRequest
{
    protected function isPostTest(): bool
    {
        return true;
    }
}
