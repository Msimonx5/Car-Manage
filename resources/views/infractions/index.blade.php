@extends('layouts.admin')

@section('title', 'Infractions')

@section('content')
@php
    $usesContracts = auth()->user()?->can('view-contracts') ?? false;
    $avatarColors = ['#4f46e5', '#0ea5e9', '#16a34a', '#f59e0b', '#8b5cf6', '#ef4444'];
@endphp

<div class="page-head">
    <div>
        <h2>Infractions</h2>
        <p>{{ $stats['total'] }} infraction(s) au total</p>
    </div>
    <a href="{{ route('infractions.create') }}" class="btn-brand">
        <i class="bi bi-plus-lg"></i> Nouvelle infraction
    </a>
</div>

@if(session('success'))
    <div class="flash ok"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>
@endif

<div class="row g-3 mb-3">
    <div class="col-6 col-lg-4"><div class="card2 stat"><div class="k">Total</div><div class="v">{{ $stats['total'] }}</div></div></div>
    <div class="col-6 col-lg-4"><div class="card2 stat"><div class="k">Clients concernes</div><div class="v" style="color:var(--info)">{{ $infractions->pluck('client_id')->filter()->unique()->count() }}</div></div></div>
    <div class="col-6 col-lg-4"><div class="card2 stat"><div class="k">Vehicules concernes</div><div class="v" style="color:var(--success)">{{ $infractions->pluck('vehicle_id')->filter()->unique()->count() }}</div></div></div>
</div>

<div class="card2">
    <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-10">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                    placeholder="{{ $usesContracts ? 'Numero contrat, client, CIN, permis ou immatriculation' : 'Client, CIN, permis ou immatriculation' }}">
            </div>
            <div class="col-md-2"><button class="btn-brand w-100 justify-content-center"><i class="bi bi-search"></i> Filtrer</button></div>
        </form>
    </div>

    <div style="padding:8px 4px 4px;overflow-x:auto">
        <table class="t2">
            <thead>
                <tr>
                    @if($usesContracts)<th>Contrat</th>@endif
                    <th>Client</th>
                    <th>CIN</th>
                    <th>Permis</th>
                    <th>Vehicule</th>
                    <th>Immatriculation</th>
                    @if($usesContracts)
                        <th>Depart</th>
                        <th>Retour</th>
                    @endif
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($infractions as $i => $infraction)
                    @php
                        $color = $avatarColors[$i % count($avatarColors)];
                        $initials = strtoupper(mb_substr($infraction->prenom ?? '', 0, 1) . mb_substr($infraction->nom ?? '', 0, 1));
                    @endphp
                    <tr>
                        @if($usesContracts)<td class="fw-semibold">{{ $infraction->numero_contrat ?? '—' }}</td>@endif
                        <td><div class="cust"><span class="av" style="background:{{ $color }}">{{ $initials ?: '—' }}</span>{{ $infraction->nom }} {{ $infraction->prenom }}</div></td>
                        <td>{{ $infraction->cin ?? '—' }}</td>
                        <td>{{ $infraction->numero_permis ?? '—' }}</td>
                        <td>{{ $infraction->marque ?? '—' }} {{ $infraction->modele }}</td>
                        <td class="fw-semibold">{{ $infraction->immatriculation ?? '—' }}</td>
                        @if($usesContracts)
                            <td>{{ $infraction->date_depart?->format('d/m/Y') ?? '—' }} @if($infraction->heure_depart)<span class="mut">· {{ \Carbon\Carbon::parse($infraction->heure_depart)->format('H:i') }}</span>@endif</td>
                            <td>{{ $infraction->date_retour?->format('d/m/Y') ?? '—' }} @if($infraction->heure_retour)<span class="mut">· {{ \Carbon\Carbon::parse($infraction->heure_retour)->format('H:i') }}</span>@endif</td>
                        @endif
                        <td style="text-align:right;white-space:nowrap">
                            <a href="{{ route('infractions.pdf', $infraction->id) }}" target="_blank" class="act pdf" title="Voir le PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                            <a href="{{ route('infractions.show', $infraction) }}" class="act view" title="Voir"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('infractions.edit', $infraction) }}" class="act edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('infractions.destroy', $infraction) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette infraction ?')">
                                @csrf
                                @method('DELETE')
                                <button class="act danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ $usesContracts ? 9 : 6 }}" class="text-center py-5 mut"><i class="bi bi-exclamation-triangle" style="font-size:28px"></i><div class="mt-2">Aucune infraction trouvee.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $infractions->links() }}</div>
@endsection
