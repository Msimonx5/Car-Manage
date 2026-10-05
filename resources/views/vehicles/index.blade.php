@extends('layouts.admin')

@section('title', 'Véhicules')

@section('content')

<style>
    .vehicle-maintenance-modal .modal-dialog {
        max-height: calc(100vh - 2rem);
    }
    .vehicle-maintenance-modal .modal-content {
        max-height: calc(100vh - 2rem);
    }
    .vehicle-maintenance-modal .modal-body {
        max-height: calc(100vh - 12rem);
        overflow-y: auto;
        overscroll-behavior: contain;
    }
</style>

<div class="page-head">
    <div>
        <h2>Véhicules</h2>
        <p>Gestion de la flotte — {{ $stats['total'] }} véhicule(s)</p>
    </div>
    <a href="{{ route('vehicles.create') }}" class="btn-brand"><i class="bi bi-plus-lg"></i> Nouveau véhicule</a>
</div>

@include('components.alerts.success')

{{-- Stat cards --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3"><div class="card2 stat"><div class="k">Total</div><div class="v">{{ $stats['total'] }}</div></div></div>
    <div class="col-6 col-md-3"><div class="card2 stat"><div class="k">Disponibles</div><div class="v" style="color:var(--success)">{{ $stats['disponible'] }}</div></div></div>
    <div class="col-6 col-md-3"><div class="card2 stat"><div class="k">Maintenance</div><div class="v" style="color:var(--warning)">{{ $stats['maintenance'] }}</div></div></div>
    <div class="col-6 col-md-3"><div class="card2 stat"><div class="k">Vidanges urgentes</div><div class="v" style="color:var(--danger)">{{ $stats['vidange_urgente'] }}</div></div></div>
</div>

<div class="card2">
    {{-- Toolbar --}}
    <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Marque, modèle ou immatriculation">
            </div>
            <div class="col-md-3">
                <select name="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    @foreach(App\Enums\VehicleStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(request('statut') == $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="latest" @selected(request('sort')=='latest')>Plus récents</option>
                    <option value="marque" @selected(request('sort')=='marque')>Marque</option>
                    <option value="kilometrage" @selected(request('sort')=='kilometrage')>Kilométrage</option>
                    <option value="prix" @selected(request('sort')=='prix')>Prix</option>
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
                <tr><th>#</th><th>Immatriculation</th><th>Véhicule</th><th>Km</th><th>Prix/Jour</th><th>Statut</th><th>Vidange</th><th>Assurance</th><th style="text-align:right">Actions</th></tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                    <tr>
                        <td class="mut">{{ $vehicle->id }}</td>
                        <td class="fw-semibold">{{ $vehicle->immatriculation }}</td>
                        <td>
                            <div class="fw-semibold">{{ $vehicle->full_name }}</div>
                            <small class="mut">{{ $vehicle->annee }} · {{ $vehicle->carburant }}</small>
                        </td>
                        <td class="nowrap">{{ number_format($vehicle->kilometrage, 0, ',', ' ') }}</td>
                        <td class="fw-semibold nowrap">{{ number_format($vehicle->prix_jour, 2, ',', ' ') }} DH</td>
                        <td><x-badge.vehicle-status :status="$vehicle->statut"/></td>
                        <td><x-badge.oil-change-status :vehicle="$vehicle"/></td>
                        <td><x-badge.insurance-status :vehicle="$vehicle"/></td>
                        <td style="text-align:right;white-space:nowrap">
                        <button type="button" class="act oil" title="Effectuer la vidange"
                                data-bs-toggle="modal" data-bs-target="#oilChangeModal{{ $vehicle->id }}">
                            <i class="bi bi-droplet"></i>
                        </button>
                        <button type="button" class="act oil" title="Suivi des filtres, pneus et freins"
                                data-bs-toggle="modal" data-bs-target="#vehicleMaintenanceModal{{ $vehicle->id }}">
                            <i class="bi bi-tools"></i>
                        </button>

                            <a href="{{ route('vehicles.show', $vehicle) }}" class="act view" title="Voir"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="act edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce véhicule ?')">
                                @csrf @method('DELETE')
                                <button class="act danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-5 mut">Aucun véhicule trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $vehicles->links() }}</div>

{{-- Les modales sont hors du conteneur du tableau pour eviter que son overflow les coupe. --}}
@foreach($vehicles as $vehicle)
    <div class="modal fade" id="oilChangeModal{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('vehicles.oil-change', $vehicle) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Enregistrer une vidange — {{ $vehicle->immatriculation }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kilométrage actuel constaté</label>
                            <input type="number" name="kilometrage_actuel" class="form-control"
                                value="{{ $vehicle->kilometrage }}" min="{{ $vehicle->kilometrage }}" required>
                            <small class="text-muted">Kilométrage actuel en base : {{ number_format($vehicle->kilometrage, 0, ',', ' ') }} km</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Intervalle avant prochaine vidange (km)</label>
                            <input type="number" name="intervalle_km" class="form-control" value="10000" min="1000">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn-brand">Confirmer la vidange</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade vehicle-maintenance-modal" id="vehicleMaintenanceModal{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('vehicles.maintenance', $vehicle) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Suivi de maintenance — {{ $vehicle->immatriculation }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <small class="text-muted d-block mb-3">Pour chaque élément changé, indiquez la date de son dernier remplacement.</small>
                        @foreach([
                            'filtre_air_date' => 'Filtre à air',
                            'filtre_huile_date' => 'Filtre à huile',
                            'filtre_carburant_date' => 'Filtre à carburant',
                            'filtre_habitacle_date' => 'Chaîne de distribution',
                        ] as $field => $label)
                            <div class="mb-3">
                                <label class="form-label">{{ $label }} — date de changement</label>
                                <input type="date" name="{{ $field }}" class="form-control"
                                    value="{{ optional($vehicle->{$field})->format('Y-m-d') }}">
                            </div>
                        @endforeach
                        @foreach([
                            ['date' => 'pneus_date', 'text' => 'pneus_description', 'label' => 'Pneus'],
                            ['date' => 'plaquettes_frein_date', 'text' => 'plaquettes_frein_description', 'label' => 'Plaquettes de frein'],
                        ] as $part)
                            <div class="mb-3">
                                <label class="form-label">{{ $part['label'] }}</label>
                                <input type="text" name="{{ $part['text'] }}" class="form-control"
                                    value="{{ $vehicle->{$part['text']} ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date du dernier changement</label>
                                <input type="date" name="{{ $part['date'] }}" class="form-control"
                                    value="{{ optional($vehicle->{$part['date']})->format('Y-m-d') }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn-brand">Enregistrer la maintenance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
