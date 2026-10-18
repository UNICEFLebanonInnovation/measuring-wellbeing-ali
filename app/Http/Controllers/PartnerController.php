<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use App\Support\Accounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PartnerController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        $partners = Partner::query()
            ->join('users', 'users.id', '=', 'partners.user_id')
            ->when($search, fn ($q) => $q->where(fn ($w) => $w
                ->where('partners.name', 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('partners.prefix', 'like', "%{$search}%")))
            ->orderBy('partners.name')
            ->withCount(['collectors', 'applications'])
            ->paginate(25, ['partners.*', 'users.email', 'users.firstname', 'users.lastname', 'users.phone', 'users.is_active', 'users.is_readonly'])
            ->withQueryString()
            ->through(fn ($p) => [
                'id' => $p->id,
                'user_id' => $p->user_id,
                'name' => $p->name,
                'prefix' => $p->prefix,
                'email' => $p->email,
                'contact' => trim($p->firstname.' '.$p->lastname),
                'phone' => $p->phone,
                'logo' => $p->logo ? asset('storage/'.$p->logo) : null,
                'max_app_per_year' => $p->max_app_per_year,
                'collectors_count' => $p->collectors_count,
                'applications_count' => $p->applications_count,
                'is_active' => (bool) $p->is_active,
                'is_readonly' => (bool) $p->is_readonly,
            ]);

        return Inertia::render('Partners/Index', ['partners' => $partners, 'search' => $search]);
    }

    public function create(): Response
    {
        return Inertia::render('Partners/Form', ['partner' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        DB::transaction(function () use ($data, $request) {
            $user = Accounts::invite([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ], User::ROLE_PARTNER);

            Partner::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'prefix' => strtoupper($data['prefix']),
                'max_app_per_year' => $data['max_app_per_year'],
                'logo' => $request->hasFile('logo') ? $request->file('logo')->store('partner_logo', 'public') : null,
            ]);
        });

        return redirect()->route('partners.index')->with('success', __('ui.partner_created'));
    }

    public function show(Partner $partner): Response
    {
        $partner->load('user');
        $collectors = Collector::query()->join('users', 'users.id', '=', 'collectors.user_id')
            ->where('collectors.partner_id', $partner->user_id)
            ->orderBy('users.firstname')
            ->get(['collectors.id', 'collectors.user_id', 'collectors.prefix', 'collectors.city', 'users.firstname', 'users.lastname', 'users.email', 'users.is_active', 'users.is_readonly'])
            ->map(fn ($c) => [
                'id' => $c->id, 'user_id' => $c->user_id, 'name' => trim($c->firstname.' '.$c->lastname),
                'email' => $c->email, 'prefix' => $c->prefix, 'city' => $c->city,
                'is_active' => (bool) $c->is_active, 'is_readonly' => (bool) $c->is_readonly,
                'applications_count' => Application::where('collector_id', $c->user_id)->count(),
            ]);

        return Inertia::render('Partners/Show', [
            'partner' => $this->serialise($partner),
            'collectors' => $collectors,
            'applications_count' => $partner->applications()->count(),
            'usage_this_year' => $partner->applications()->where('year', now()->year)->count(),
        ]);
    }

    public function edit(Partner $partner): Response
    {
        $partner->load('user');

        return Inertia::render('Partners/Form', ['partner' => $this->serialise($partner)]);
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $this->validateData($request, $partner);

        DB::transaction(function () use ($data, $request, $partner) {
            $partner->user->update([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);
            $partner->update([
                'name' => $data['name'],
                'prefix' => strtoupper($data['prefix']),
                'max_app_per_year' => $data['max_app_per_year'],
                'logo' => $request->hasFile('logo') ? $request->file('logo')->store('partner_logo', 'public') : $partner->logo,
            ]);
        });

        return redirect()->route('partners.show', $partner)->with('success', __('ui.saved'));
    }

    public function flags(Request $request, Partner $partner): RedirectResponse
    {
        $data = $request->validate([
            'is_active' => ['sometimes', 'boolean'],
            'is_readonly' => ['sometimes', 'boolean'],
            'resend_invite' => ['sometimes', 'boolean'],
        ]);
        $partner->user->fill(collect($data)->only(['is_active', 'is_readonly'])->all())->save();
        if ($request->boolean('resend_invite')) {
            Accounts::sendSetupLink($partner->user, User::ROLE_PARTNER);
        }

        return back()->with('success', __('ui.saved'));
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->applications()->exists()) {
            return back()->with('error', __('ui.partner_has_applications'));
        }
        DB::transaction(function () use ($partner) {
            $partner->user?->delete();
            $partner->delete();
        });

        return redirect()->route('partners.index')->with('success', __('ui.deleted'));
    }

    private function validateData(Request $request, ?Partner $partner = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prefix' => ['required', 'string', 'alpha_num:ascii', 'max:10', Rule::unique('partners', 'prefix')->ignore($partner?->id)],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($partner?->user_id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'max_app_per_year' => ['required', 'integer', 'min:0', 'max:100000'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function serialise(Partner $partner): array
    {
        return [
            'id' => $partner->id,
            'user_id' => $partner->user_id,
            'name' => $partner->name,
            'prefix' => $partner->prefix,
            'max_app_per_year' => $partner->max_app_per_year,
            'logo' => $partner->logo ? asset('storage/'.$partner->logo) : null,
            'firstname' => $partner->user?->firstname,
            'lastname' => $partner->user?->lastname,
            'email' => $partner->user?->email,
            'phone' => $partner->user?->phone,
            'address' => $partner->user?->address,
            'is_active' => (bool) $partner->user?->is_active,
            'is_readonly' => (bool) $partner->user?->is_readonly,
        ];
    }
}
