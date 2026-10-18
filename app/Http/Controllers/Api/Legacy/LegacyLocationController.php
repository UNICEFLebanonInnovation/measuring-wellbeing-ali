<?php

namespace App\Http\Controllers\Api\Legacy;

use App\Http\Controllers\Api\ApiController;
use App\Models\Area;
use App\Models\Caza;
use App\Models\Gouvernate;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LegacyLocationController extends ApiController
{
    public function governorates(): JsonResponse
    {
        return $this->success(Gouvernate::all()->toArray(), 'Success');
    }

    public function cazas(Request $request): JsonResponse
    {
        if (! $request->filled('gouvernate_id')) {
            return response()->json(['success' => false, 'message' => 'Validation Error.', 'data' => ['gouvernate_id' => ['The gouvernate id field is required.']]], 404);
        }

        return $this->success(Caza::where('gouvernate_id', $request->input('gouvernate_id'))->get()->toArray(), 'Success');
    }

    public function areas(Request $request): JsonResponse
    {
        if (! $request->filled('caza_id')) {
            return response()->json(['success' => false, 'message' => 'Validation Error.', 'data' => ['caza_id' => ['The caza id field is required.']]], 404);
        }

        return $this->success(Area::where('caza_id', $request->input('caza_id'))->get()->toArray(), 'Success');
    }

    public function statuses(): JsonResponse
    {
        return $this->success(Status::all()->toArray(), 'Success');
    }

    public function all(): JsonResponse
    {
        return $this->success([
            'gouvernates' => Gouvernate::all()->toArray(),
            'caza' => Caza::all()->toArray(),
            'area' => Area::all()->toArray(),
        ], 'Success');
    }
}
