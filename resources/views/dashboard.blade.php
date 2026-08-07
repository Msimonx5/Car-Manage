@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid py-4">

```
{{-- ============================================================
    HEADER
============================================================ --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </h2>

        <p class="text-muted mb-0">
            Vue générale de votre activité de location
        </p>
    </div>

    <div class="mt-3 mt-md-0">
        <span class="badge bg-light text-dark border px-3 py-2">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

</div>


{{-- ============================================================
    KPI
============================================================ --}}
<div class="row g-4 mb-4">

    {{-- Clients --}}
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Clients
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $totalClients }}
                        </h3>
                    </div>

                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-people fs-4 text-primary"></i>
                    </div>

                </div>

                <div class="mt-3">
                    <a href="{{ route('clients.index') }}"
                       class="text-decoration-none small">
                        Voir les clients
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

            </div>

        </div>
    </div>


    {{-- Véhicules --}}
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Véhicules
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $totalVehicles }}
                        </h3>
                    </div>

                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-car-front fs-4 text-success"></i>
                    </div>

                </div>

                <div class="mt-3">
                    <span class="text-success small">
                        {{ $availableVehicles }} disponibles
                    </span>
                </div>

            </div>

        </div>
    </div>


    {{-- Contrats --}}
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Contrats
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $totalContracts }}
                        </h3>
                    </div>

                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-file-earmark-text fs-4 text-warning"></i>
                    </div>

                </div>

                <div class="mt-3">
                    <span class="text-warning small">
                        {{ $activeContracts }} en cours
                    </span>
                </div>

            </div>

        </div>
    </div>


    {{-- Chiffre d'affaires --}}
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Chiffre d'affaires
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ number_format($totalRevenue, 2, ',', ' ') }}
                            <small class="fs-6">DH</small>
                        </h3>
                    </div>

                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-cash-coin fs-4 text-info"></i>
                    </div>

                </div>

                <div class="mt-3">
                    <span class="text-muted small">
                        Ce mois :
                        <strong>
                            {{ number_format($monthlyRevenue, 2, ',', ' ') }} DH
                        </strong>
                    </span>
                </div>

            </div>

        </div>
    </div>

</div>


{{-- ============================================================
    VEHICULES + CONTRATS
============================================================ --}}
<div class="row g-4 mb-4">

    {{-- Etat des véhicules --}}
    <div class="col-xl-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-car-front me-2"></i>
                    État des véhicules
                </h5>
            </div>

            <div class="card-body px-4">

                {{-- Disponible --}}
                <div class="mb-4">

                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            <span class="badge bg-success me-2">&nbsp;</span>
                            Disponibles
                        </span>

                        <strong>{{ $availableVehicles }}</strong>
                    </div>

                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success"
                             style="width: {{ $totalVehicles > 0 ? ($availableVehicles / $totalVehicles) * 100 : 0 }}%">
                        </div>
                    </div>

                </div>


                {{-- Loués --}}
                <div class="mb-4">

                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            <span class="badge bg-primary me-2">&nbsp;</span>
                            Loués
                        </span>

                        <strong>{{ $rentedVehicles }}</strong>
                    </div>

                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary"
                             style="width: {{ $totalVehicles > 0 ? ($rentedVehicles / $totalVehicles) * 100 : 0 }}%">
                        </div>
                    </div>

                </div>


                {{-- Maintenance --}}
                <div class="mb-4">

                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            <span class="badge bg-warning me-2">&nbsp;</span>
                            Maintenance
                        </span>

                        <strong>{{ $maintenanceVehicles }}</strong>
                    </div>

                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning"
                             style="width: {{ $totalVehicles > 0 ? ($maintenanceVehicles / $totalVehicles) * 100 : 0 }}%">
                        </div>
                    </div>

                </div>


                {{-- Réservés --}}
                <div class="mb-4">

                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            <span class="badge bg-info me-2">&nbsp;</span>
                            Réservés
                        </span>

                        <strong>{{ $reservedVehicles }}</strong>
                    </div>

                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info"
                             style="width: {{ $totalVehicles > 0 ? ($reservedVehicles / $totalVehicles) * 100 : 0 }}%">
                        </div>
                    </div>

                </div>


                {{-- Hors service --}}
                <div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            <span class="badge bg-danger me-2">&nbsp;</span>
                            Hors service
                        </span>

                        <strong>{{ $outOfServiceVehicles }}</strong>
                    </div>

                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger"
                             style="width: {{ $totalVehicles > 0 ? ($outOfServiceVehicles / $totalVehicles) * 100 : 0 }}%">
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Etat des contrats --}}
    <div class="col-xl-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    État des contrats
                </h5>
            </div>

            <div class="card-body px-4">

                <div class="row g-3">

                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="text-muted small">
                                En attente
                            </div>

                            <div class="fs-3 fw-bold text-warning">
                                {{ $pendingContracts }}
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="text-muted small">
                                En cours
                            </div>

                            <div class="fs-3 fw-bold text-primary">
                                {{ $activeContracts }}
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="text-muted small">
                                Terminés
                            </div>

                            <div class="fs-3 fw-bold text-success">
                                {{ $finishedContracts }}
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="text-muted small">
                                Annulés
                            </div>

                            <div class="fs-3 fw-bold text-danger">
                                {{ $cancelledContracts }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
    ALERTES
============================================================ --}}
<div class="row g-4 mb-4">

    {{-- Vidanges --}}
    <div class="col-xl-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-tools text-danger me-2"></i>
                    Vidanges
                </h5>

            </div>

            <div class="card-body px-4">

                @forelse($oilChangeAlerts as $vehicle)

                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">

                        <div>
                            <strong>
                                {{ $vehicle->full_name }}
                            </strong>

                            <div class="small text-muted">
                                {{ number_format($vehicle->kilometrage, 0, ',', ' ') }} km
                            </div>
                        </div>

                        <span class="badge bg-danger">
                            Urgent
                        </span>

                    </div>

                @empty

                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle fs-2 text-success"></i>

                        <p class="mb-0 mt-2">
                            Aucune vidange urgente
                        </p>
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- Assurances --}}
    <div class="col-xl-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-shield-exclamation text-warning me-2"></i>
                    Assurances
                </h5>

            </div>

            <div class="card-body px-4">

                @forelse($insuranceAlerts as $vehicle)

                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">

                        <div>
                            <strong>
                                {{ $vehicle->full_name }}
                            </strong>

                            <div class="small text-muted">
                                {{ $vehicle->assurance_expiration?->format('d/m/Y') }}
                            </div>
                        </div>

                        <span class="badge bg-danger">
                            Expirée
                        </span>

                    </div>

                @empty

                    <div class="text-center text-muted py-4">

                        <i class="bi bi-check-circle fs-2 text-success"></i>

                        <p class="mb-0 mt-2">
                            Aucune assurance expirée
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- Visite technique --}}
    <div class="col-xl-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clipboard2-check text-danger me-2"></i>
                    Visite technique
                </h5>

            </div>

            <div class="card-body px-4">

                @forelse($technicalAlerts as $vehicle)

                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">

                        <div>
                            <strong>
                                {{ $vehicle->full_name }}
                            </strong>

                            <div class="small text-muted">
                                {{ $vehicle->visite_technique?->format('d/m/Y') }}
                            </div>
                        </div>

                        <span class="badge bg-danger">
                            Expirée
                        </span>

                    </div>

                @empty

                    <div class="text-center text-muted py-4">

                        <i class="bi bi-check-circle fs-2 text-success"></i>

                        <p class="mb-0 mt-2">
                            Aucune visite expirée
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
    CONTRATS À RETOURNER
============================================================ --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white border-0 pt-4 px-4">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-calendar-check me-2"></i>
                Contrats à retourner aujourd'hui
            </h5>

            <span class="badge bg-primary">
                {{ $contractsToday->count() }}
            </span>

        </div>

    </div>

    <div class="card-body p-0">

        @if($contractsToday->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th class="px-4">Contrat</th>
                            <th>Client</th>
                            <th>Véhicule</th>
                            <th>Heure</th>
                            <th>Statut</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($contractsToday as $contract)

                            <tr>

                                <td class="px-4 fw-semibold">
                                    {{ $contract->numero }}
                                </td>

                                <td>
                                    {{ $contract->client?->prenom }}
                                    {{ $contract->client?->nom }}
                                </td>

                                <td>
                                    {{ $contract->vehicle?->full_name }}
                                </td>

                                <td>
                                    {{ $contract->heure_retour }}
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        En cours
                                    </span>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5 text-muted">

                <i class="bi bi-calendar-check fs-1"></i>

                <p class="mt-2 mb-0">
                    Aucun véhicule à retourner aujourd'hui.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- ============================================================
    DERNIERS CONTRATS
============================================================ --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white border-0 pt-4 px-4">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-clock-history me-2"></i>
                Derniers contrats
            </h5>

            <a href="{{ route('contracts.index') }}"
               class="btn btn-sm btn-outline-primary">

                Voir tous

                <i class="bi bi-arrow-right ms-1"></i>

            </a>

        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4">
                            N°
                        </th>

                        <th>
                            Client
                        </th>

                        <th>
                            Véhicule
                        </th>

                        <th>
                            Départ
                        </th>

                        <th>
                            Retour
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Statut
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($recentContracts as $contract)

                        <tr>

                            <td class="px-4 fw-semibold">
                                {{ $contract->numero }}
                            </td>


                            <td>

                                @if($contract->client)

                                    {{ $contract->client->prenom }}
                                    {{ $contract->client->nom }}

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($contract->vehicle)

                                    <div class="fw-semibold">
                                        {{ $contract->vehicle->full_name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $contract->vehicle->immatriculation }}
                                    </small>

                                @else

                                    —

                                @endif

                            </td>


                            <td>
                                {{ $contract->date_depart?->format('d/m/Y') }}
                            </td>


                            <td>
                                {{ $contract->date_retour?->format('d/m/Y') }}
                            </td>


                            <td class="fw-semibold">

                                {{ number_format(
                                    $contract->total_ttc,
                                    2,
                                    ',',
                                    ' '
                                ) }}

                                DH

                            </td>


                            <td>

                                @php

                                    $status = $contract->statut;

                                    $statusClass = match($status->value) {

                                        'en_attente' => 'warning',

                                        'en_cours' => 'primary',

                                        'termine' => 'success',

                                        'annule' => 'danger',

                                        default => 'secondary',

                                    };

                                    $statusLabel = match($status->value) {

                                        'en_attente' => 'En attente',

                                        'en_cours' => 'En cours',

                                        'termine' => 'Terminé',

                                        'annule' => 'Annulé',

                                        default => 'Inconnu',

                                    };

                                @endphp


                                <span class="badge bg-{{ $statusClass }}">

                                    {{ $statusLabel }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5 text-muted">

                                <i class="bi bi-file-earmark-x fs-1"></i>

                                <p class="mt-2 mb-0">
                                    Aucun contrat trouvé.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
```

</div>

@endsection
