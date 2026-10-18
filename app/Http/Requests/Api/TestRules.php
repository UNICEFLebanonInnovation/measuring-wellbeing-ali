<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\PostTestRequest;
use App\Http\Requests\PreTestRequest;
use App\Sdq\SdqItems;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Validator;

/**
 * Builds a validator for questionnaire payloads outside the HTTP
 * FormRequest lifecycle (batch sync), using exactly the same rules as
 * PreTestRequest / PostTestRequest.
 */
final class TestRules
{
    public static function normalise(array $data): array
    {
        foreach (SdqItems::all() as $item) {
            if (isset($data[$item]) && is_string($data[$item])) {
                $data[$item] = strtolower($data[$item]);
            }
        }

        return $data;
    }

    public static function validator(array $data, bool $postTest): ValidatorContract
    {
        $data = self::normalise($data);
        $request = $postTest
            ? PostTestRequest::create('/api/v1/sync', 'POST', $data)
            : PreTestRequest::create('/api/v1/sync', 'POST', $data);

        return Validator::make($data, $request->rules());
    }
}
