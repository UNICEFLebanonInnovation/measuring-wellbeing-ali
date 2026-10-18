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

class CollectorController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $search = $request->string('search')->toString();
        $partnerFilter = $request->integer('partner') ?: null;

        $collectors = Collector::query()
            ->join('users', 'users.id', '=', 'collectors.user_id')
            ->leftJoin('partners', 'partners.user_id', '=', 'collectors.partner_id')
            ->when($user->isPartner(), fn ($q) => $q->where('collectors.partner_id', $user->id))
            ->when($user->isAdmin() && $partnerFilter, fn ($q) => $q->where('collectors.partner_id', $partnerFilter))
            ->when($search, fn ($q) => $q->where(fn ($w) => $w
                ->where('users.firstname', 'like', "%{$search}%")
                ->orWhere('users.lastname', 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('collectors.prefix', 'like', "%{$search}%")))
            ->orderBy('users.firstname')
            ->paginate(25, ['collectors.*', 'users.firstname', 'users.lastname', 'users.email', 'users.phone', 'users.is_active', 'users.is_readonly', 'partners.name as partner_name'])
            ->withQueryString()
            ->through(fn ($c) => [
                'id' => $c->id,
                'user_id' => $c->user_id,
                'name' => trim($c->firstname.' '.$c->lastname),
                'email' => $c->email,
                'phone' => $c->phone,
                'prefix' => $c->prefix,
                'city' => $c->city,
                'partner' => $c->partner_name,
                'is_subpartner' => (bool) $c->is_subpartner,
                'sub_partner' => $c->sub_partner,
                'is_active' => (bool) $c->is_active,
                'is_readonly' => (bool) $c->is_readonly,
                'applications_count' => Application::where('collector_id', $c->user_id)->count(),
            ]);

        return Inertia::render('Collectors/Index', [
            'collectors' => $collectors,
            'search' => $search,
            'partner' => $partnerFilter,
            'partners' => $user->isAdmin() ? Partner::orderBy('name')->get(['user_id as id', 'name']) : [],
            'canCreate' => $user->isPartner() && ! $user->is_readonly,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Collectors/Form', ['collector' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $partnerUser = $request->user();
        abort_if($partnerUser->is_readonly, 403);
        $data = $this->validateData($request);

        DB::transaction(function () use ($data, $partnerUser) {
            $user = Accounts::invite([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
            ], User::ROLE_COLLECTOR);

            Collector::create([
                'user_id' => $user->id,
                'partner_id' => $partnerUser->id,
                'name' => trim($data['firstname'].' '.$data['lastname']),
                'prefix' => strtoupper($data['prefix']),
                'city' => $data['city'] ?? null,
                'is_subpartner' => (bool) ($data['is_subpartner'] ?? false),
                'sub_partner' => ($data['is_subpartner'] ?? false) ? ($data['sub_partner'] ?? null) : null,
            ]);
        });

        return redirect()->route('collectors.index')->with('success', __('ui.collector_created'));
    }

    public function edit(Request $request, Collector $collector): Response
    {
        $this->authorizeCollector($request->user(), $collector);
        $collector->load('user');

        return Inertia::render('Collectors/Form', ['collector' => [
            'id' => $collector->id,
            'firstname' => $collector->user?->firstname,
            'lastname' => $collector->user?->lastname,
            'email' => $collector->user?->email,
            'phone' => $collector->user?->phone,
            'prefix' => $collector->prefix,
            'city' => $collector->city,
            'is_subpartner' => (bool) $collector->is_subpartner,
            'sub_partner' => $collector->sub_partner,
        ]]);
    }

    public function update(Request $request, Collector $collector): RedirectResponse
    {
        $this->authorizeCollector($request->user(), $collector);
        $data = $this->validateData($request, $collector);

        DB::transaction(function () use ($data, $collector) {
            $collector->user->update([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
            ]);
            $collector->update([
                'name' => trim($data['firstname'].' '.$data['lastname']),
                'prefix' => strtoupper($data['prefix']),
                'city' => $data['city'] ?? null,
                'is_subpartner' => (bool) ($data['is_subpartner'] ?? false),
                'sub_partner' => ($data['is_subpartner'] ?? false) ? ($data['sub_partner'] ?? null) : null,
            ]);
        });

        return redirect()->route('collectors.index')->with('success', __('ui.saved'));
    }

    public function flags(Request $request, Collector $collector): RedirectResponse
    {
        $this->authorizeCollector($request->user(), $collector);
        $data = $request->validate([
            'is_active' => ['sometimes', 'boolean'],
            'is_readonly' => ['sometimes', 'boolean'],
            'resend_invite' => ['sometimes', 'boolean'],
        ]);
        $collector->user->fill(collect($data)->only(['is_active', 'is_readonly'])->all())->save();
        if ($request->boolean('resend_invite')) {
            Accounts::sendSetupLink($collector->user, User::ROLE_COLLECTOR);
        }

        return back()->with('success', __('ui.saved'));
    }

    public function destroy(Request $request, Collector $collector): RedirectResponse
    {
        $this->authorizeCollector($request->user(), $collector);
        if (Application::where('collector_id', $collector->user_id)->exists()) {
            return back()->with('error', __('ui.collector_has_applications'));
        }
        DB::transaction(function () use ($collector) {
            $collector->user?->delete();
            $collector->delete();
        });

        return redirect()->route('collectors.index')->with('success', __('ui.deleted'));
    }

    private function validateData(Request $request, ?Collector $collector = null): array
    {
        $partnerUserId = $request->user()->isPartner() ? $request->user()->id : $collector?->partner_id;

        return $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($collector?->user_id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'prefix' => ['required', 'string', 'alpha_num:ascii', 'max:10',
                Rule::unique('collectors', 'prefix')->where('partner_id', $partnerUserId)->ignore($collector?->id)],
            'city' => ['nullable', 'string', 'max:255'],
            'is_subpartner' => ['nullable', 'boolean'],
            'sub_partner' => ['nullable', 'string', 'max:50', 'required_if:is_subpartner,true'],
        ]);
    }

    private function authorizeCollector(User $user, Collector $collector): void
    {
        if ($user->isAdmin()) {
            return;
        }
        abort_unless($user->isPartner() && $collector->partner_id === $user->id, 403);
    }
}
