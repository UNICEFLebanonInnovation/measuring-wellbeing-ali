<?php

namespace App\Http\Controllers;

use App\Models\ApplicationValue;
use App\Models\Area;
use App\Models\Caza;
use App\Models\Gouvernate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
    public function index(Request $request): Response
    {
        $governorate = $request->integer('governorate') ?: null;
        $caza = $request->integer('caza') ?: null;

        return Inertia::render('Locations/Index', [
            'governorates' => Gouvernate::orderBy('name')->withCount('cazas')->get(['id', 'name', 'arabic']),
            'cazas' => $governorate
                ? Caza::where('gouvernate_id', $governorate)->orderBy('name')->withCount('areas')->get(['id', 'gouvernate_id', 'name', 'arabic'])
                : [],
            'areas' => $caza
                ? Area::where('caza_id', $caza)->orderBy('name')->get(['id', 'caza_id', 'gouvernate_id', 'name', 'arabic'])
                : [],
            'selected' => ['governorate' => $governorate, 'caza' => $caza],
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'arabic' => ['nullable', 'string', 'max:50'],
            'gouvernate_id' => ['required_if:type,caza', 'nullable', 'exists:gouvernate,id'],
            'caza_id' => ['required_if:type,area', 'nullable', 'exists:caza,id'],
        ]);

        match ($type) {
            'governorate' => Gouvernate::create($data),
            'caza' => Caza::create($data),
            'area' => Area::create($data + ['gouvernate_id' => Caza::findOrFail($data['caza_id'])->gouvernate_id]),
        };

        return back()->with('success', __('ui.saved'));
    }

    public function update(Request $request, string $type, int $id): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'arabic' => ['nullable', 'string', 'max:50'],
        ]);
        $this->model($type)::findOrFail($id)->update($data);

        return back()->with('success', __('ui.saved'));
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $model = $this->model($type)::findOrFail($id);
        $column = match ($type) {
            'governorate' => 'gouvarnate',
            'caza' => 'caza',
            'area' => 'area',
        };
        $inUse = ApplicationValue::where($column, (string) $id)->exists()
            || ($type === 'governorate' && Caza::where('gouvernate_id', $id)->exists())
            || ($type === 'caza' && Area::where('caza_id', $id)->exists());
        if ($inUse) {
            return back()->with('error', __('ui.location_in_use'));
        }
        $model->delete();

        return back()->with('success', __('ui.deleted'));
    }

    public function cazas(int $governorate): JsonResponse
    {
        return response()->json(Caza::where('gouvernate_id', $governorate)->orderBy('name')->get(['id', 'name', 'arabic']));
    }

    public function areas(int $caza): JsonResponse
    {
        return response()->json(Area::where('caza_id', $caza)->orderBy('name')->get(['id', 'name', 'arabic']));
    }

    private function model(string $type): string
    {
        return match ($type) {
            'governorate' => Gouvernate::class,
            'caza' => Caza::class,
            'area' => Area::class,
        };
    }
}
