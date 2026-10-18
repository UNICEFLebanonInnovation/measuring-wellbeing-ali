<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Area;
use App\Models\Caza;
use App\Models\Form;
use App\Models\Gouvernate;
use App\Models\Status;
use App\Sdq\FormOptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Everything the mobile app needs to cache for offline work, in one call.
 * The response carries an ETag; send it back as If-None-Match to get 304.
 */
class ReferenceController extends ApiController
{
    public function __invoke(Request $request): JsonResponse
    {
        $cazas = Caza::orderBy('name')->get(['id', 'gouvernate_id', 'name', 'arabic'])->groupBy('gouvernate_id');
        $areas = Area::orderBy('name')->get(['id', 'caza_id', 'gouvernate_id', 'name', 'arabic'])->groupBy('caza_id');

        $governorates = Gouvernate::orderBy('name')->get(['id', 'name', 'arabic'])->map(fn (Gouvernate $g) => [
            'id' => $g->id,
            'name' => $g->name,
            'arabic' => $g->arabic,
            'cazas' => ($cazas->get($g->id) ?? collect())->map(fn (Caza $c) => [
                'id' => $c->id,
                'name' => $c->name,
                'arabic' => $c->arabic,
                'areas' => ($areas->get($c->id) ?? collect())->map(fn (Area $a) => [
                    'id' => $a->id, 'name' => $a->name, 'arabic' => $a->arabic,
                ])->values(),
            ])->values(),
        ]);

        $payload = [
            'statuses' => Status::orderBy('id')->get(['id', 'name']),
            'forms' => Form::orderBy('id')->get(['id', 'name']),
            'governorates' => $governorates,
            'options' => FormOptions::all(),
            'scoring' => [
                'policy' => config('sdq.scoring_policy'),
                'max_na_answers' => (int) config('sdq.max_na_answers', 3),
            ],
        ];

        $version = sha1(json_encode($payload));
        $payload['version'] = $version;

        if (trim((string) $request->header('If-None-Match'), '"') === $version) {
            return response()->json(null, 304);
        }

        return $this->success($payload)->setEtag($version);
    }
}
