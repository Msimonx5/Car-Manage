@extends('layouts.admin')

@section('title', 'Contrats de location')

@section('content')

@php $avatarColors = ['#4f46e5','#0ea5e9','#16a34a','#f59e0b','#8b5cf6','#ef4444']; @endphp

<div class="page-head">
    <div>
        <h2>Contrats de location</h2>
        <p>{{ $stats['total'] }} contrat(s) au total</p>
    </div>
    <a href="{{ route('contracts.create') }}" class="btn-brand"><i class="bi bi-plus-lg"></i> Nouveau contrat</a>
</div>

@if(session('success'))
    <div class="flash ok"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>
@endif

{{-- Stat cards --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-lg-2"><div class="card2 stat"><div class="k">Total</div><div class="v">{{ $stats['total'] }}</div></div></div>
    <div class="col-6 col-lg-2"><div class="card2 stat"><div class="k">En attente</div><div class="v" style="color:var(--warning)">{{ $stats['en_attente'] }}</div></div></div>
    <div class="col-6 col-lg-2"><div class="card2 stat"><div class="k">En cours</div><div class="v" style="color:var(--info)">{{ $stats['en_cours'] }}</div></div></div>
    <div class="col-6 col-lg-2"><div class="card2 stat"><div class="k">Terminés</div><div class="v" style="color:var(--success)">{{ $stats['termine'] }}</div></div></div>
    <div class="col-6 col-lg-2"><div class="card2 stat"><div class="k">Annulés</div><div class="v" style="color:var(--danger)">{{ $stats['annule'] }}</div></div></div>
    <div class="col-6 col-lg-2"><div class="card2 stat"><div class="k">Chiffre d'affaires</div><div class="v" style="font-size:18px">{{ number_format($stats['chiffre_affaires'], 0, ',', ' ') }} DH</div></div></div>
</div>

<div class="card2">
    {{-- Toolbar --}}
    <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="N° contrat, client ou véhicule">
            </div>
            <div class="col-md-4">
                <select name="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    @foreach(App\Enums\ContractStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(request('statut') == $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn-brand w-100 justify-content-center"><i class="bi bi-search"></i> Filtrer</button>
            </div>
        </form>
    </div>

    <div style="padding:8px 4px 4px;overflow-x:auto">
        <table class="t2">
            <thead>
                <tr><th>N°</th><th>Client</th><th>Véhicule</th><th>Départ</th><th>Retour</th><th>Durée</th><th>Total</th><th>Reste</th><th>Statut</th><th style="text-align:right">Actions</th></tr>
            </thead>
            <tbody>
                @forelse($contracts as $i => $contract)
                    @php
                        $color = $avatarColors[$i % count($avatarColors)];
                        $initials = strtoupper(mb_substr($contract->client?->prenom ?? '', 0, 1) . mb_substr($contract->client?->nom ?? '', 0, 1));
                        $reste = (float) $contract->total_ttc - (float) $contract->avance;
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $contract->numero }}</td>
                        <td>
                            <div class="cust">
                                <span class="av" style="background:{{ $color }}">{{ $initials ?: '—' }}</span>
                                {{ $contract->client_full_name }}
                            </div>
                        </td>
                        <td>
                            {{ $contract->vehicle_name }}
                            <span class="mut">· {{ $contract->vehicle?->immatriculation }}</span>
                        </td>
                        <td>{{ $contract->date_depart->format('d/m/Y') }}</td>
                        <td>{{ $contract->date_retour->format('d/m/Y') }}</td>
                        <td>
                            {{ $contract->duration }} j
                            @if($contract->is_expired)<span class="pill danger" style="margin-left:4px">Expiré</span>@endif
                        </td>
                        <td class="fw-semibold nowrap">{{ number_format($contract->total_ttc, 2, ',', ' ') }} DH</td>
                        <td class="nowrap">
                            @if($reste > 0)
                                <span style="color:var(--danger);font-weight:700">{{ number_format($reste, 2, ',', ' ') }} DH</span>
                            @else
                                <span class="pill success">Payé</span>
                            @endif
                        </td>
                        <td><span class="pill {{ $contract->status_color }}">{{ $contract->statut->label() }}</span></td>
                        <td style="text-align:right;white-space:nowrap">
                            <a href="{{ route('contracts.pdf', $contract) }}" class="act view" title="PDF" target="_blank"><i class="bi bi-file-earmark-pdf"></i></a>
                            <a href="{{ route('contracts.show', $contract) }}" class="act view" title="Voir"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('contracts.edit', $contract) }}" class="act edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('contracts.destroy', $contract) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce contrat ?')">
                                @csrf @method('DELETE')
                                <button class="act danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center py-5 mut">Aucun contrat trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $contracts->links() }}</div>

@endsection
