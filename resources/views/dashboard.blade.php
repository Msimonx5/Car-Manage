<<<<<<< HEAD
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
=======
@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

@php
    $pillMap = [
        'en_attente' => ['attente', 'En attente'],
        'en_cours'   => ['cours', 'En cours'],
        'termine'    => ['termine', 'Terminé'],
        'annule'     => ['annule', 'Annulé'],
    ];
    $avatarColors = ['#4f46e5', '#0ea5e9', '#16a34a', '#f59e0b', '#8b5cf6', '#ef4444'];
@endphp

{{-- ===================== KPI ROW ===================== --}}
<div class="row g-3 mb-3">

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('clients.index') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-primary"><i class="bi bi-people"></i></div>
                <span class="trend {{ $newClientsThisMonth > 0 ? 'up' : 'flat' }}">
                    <i class="bi bi-arrow-up-short"></i>{{ $newClientsThisMonth }}
                </span>
            </div>
            <div class="val">{{ $totalClients }}</div>
            <div class="lbl">Clients enregistrés</div>
            <div class="sub">{{ $newClientsThisMonth }} nouveau(x) ce mois-ci</div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('vehicles.index') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-success"><i class="bi bi-car-front"></i></div>
                <span class="trend flat">{{ $fleetUtilization }}% util.</span>
            </div>
            <div class="val">{{ $totalVehicles }}</div>
            <div class="lbl">Véhicules — flotte</div>
            <div class="sub">
                <span style="color:var(--success);font-weight:600">{{ $availableVehicles }} disponibles</span>
                · {{ $rentedVehicles }} loués
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('contracts.index') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-warning"><i class="bi bi-file-earmark-text"></i></div>
                <span class="trend flat">{{ $activeContracts }} actifs</span>
            </div>
            <div class="val">{{ $totalContracts }}</div>
            <div class="lbl">Contrats au total</div>
            <div class="sub">
                <span style="color:var(--info);font-weight:600">{{ $activeContracts }} en cours</span>
                · {{ $pendingContracts }} en attente
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="{{ route('contracts.index') }}" class="card2 kpi kpi-link">
            <div class="top">
                <div class="ic tint-info"><i class="bi bi-cash-coin"></i></div>
                @if(is_null($revenueTrend))
                    <span class="trend flat">—</span>
                @elseif($revenueTrend >= 0)
                    <span class="trend up"><i class="bi bi-arrow-up-short"></i>{{ $revenueTrend }}%</span>
                @else
                    <span class="trend down"><i class="bi bi-arrow-down-short"></i>{{ abs($revenueTrend) }}%</span>
                @endif
            </div>
            <div class="val">{{ number_format($totalRevenue, 0, ',', ' ') }}
                <small style="font-size:14px;font-weight:600;color:var(--muted)">DH</small></div>
            <div class="lbl">Chiffre d'affaires</div>
            <div class="sub">Ce mois : <b>{{ number_format($monthlyRevenue, 0, ',', ' ') }} DH</b></div>
        </a>
>>>>>>> origin/location_V_0.2
    </div>

</div>

<<<<<<< HEAD

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
=======
{{-- ===================== CHART + DOUGHNUT ===================== --}}
<div class="row g-3 mb-3">
    <div class="col-xl-8">
        <div class="card2 h-100">
            <div class="hd"><h5>Chiffre d'affaires</h5><span class="mut" style="font-size:12.5px">6 derniers mois</span></div>
            <div style="padding:8px 16px 16px"><canvas id="revChart" height="120"></canvas></div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card2 h-100">
            <div class="hd"><h5>État de la flotte</h5></div>
            <div style="padding:16px 20px 20px">
                <div style="max-width:200px;margin:0 auto 18px"><canvas id="fleetChart"></canvas></div>
                <div class="legend">
                    <div class="row2"><span class="dot" style="background:var(--success)"></span><span class="t">Disponibles</span><span class="n">{{ $availableVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:var(--primary)"></span><span class="t">Loués</span><span class="n">{{ $rentedVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:var(--warning)"></span><span class="t">Maintenance</span><span class="n">{{ $maintenanceVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:var(--info)"></span><span class="t">Réservés</span><span class="n">{{ $reservedVehicles }}</span></div>
                    <div class="row2"><span class="dot" style="background:#cbd5e1"></span><span class="t">Hors service</span><span class="n">{{ $outOfServiceVehicles }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== CONTRACT STATUS + ALERTS ===================== --}}
<div class="row g-3 mb-3">
    <div class="col-xl-8">
        <div class="card2 h-100">
            <div class="hd"><h5>État des contrats</h5><a href="{{ route('contracts.index') }}">Voir tous</a></div>
            <div style="padding:18px 20px 20px">
                <div class="row g-3">
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">🕓 En attente</div><div class="v" style="color:var(--warning)">{{ $pendingContracts }}</div></div></div>
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">🚗 En cours</div><div class="v" style="color:var(--info)">{{ $activeContracts }}</div></div></div>
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">✅ Terminés</div><div class="v" style="color:var(--success)">{{ $finishedContracts }}</div></div></div>
                    <div class="col-6 col-md-3"><div class="ministat"><div class="k">✖ Annulés</div><div class="v" style="color:var(--danger)">{{ $cancelledContracts }}</div></div></div>
                </div>
                @php $t = max($totalContracts, 1); @endphp
                <div style="margin-top:18px">
                    <div class="d-flex justify-content-between mb-2" style="font-size:12.5px;color:var(--muted)">
                        <span>Taux de conversion (hors annulés)</span>
                        <span style="font-weight:700;color:var(--ink)">{{ $conversionRate }}%</span>
                    </div>
                    <div style="height:10px;border-radius:20px;background:#eef0f4;overflow:hidden;display:flex">
                        <div style="width:{{ $pendingContracts / $t * 100 }}%;background:var(--warning)"></div>
                        <div style="width:{{ $activeContracts / $t * 100 }}%;background:var(--info)"></div>
                        <div style="width:{{ $finishedContracts / $t * 100 }}%;background:var(--success)"></div>
                        <div style="width:{{ $cancelledContracts / $t * 100 }}%;background:var(--danger)"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card2 h-100">
            <div class="hd"><h5>Alertes à traiter</h5>
                <span class="badge rounded-pill" style="background:var(--danger-tint);color:var(--danger)">{{ $alerts->count() }}</span>
            </div>
            <div style="padding:6px 20px 16px">
                @forelse($alerts as $a)
                    <div class="alert2">
                        <div class="ic tint-{{ $a['tint'] }}"><i class="bi {{ $a['icon'] }}"></i></div>
                        <div class="g"><b>{{ $a['title'] }}</b><div>{{ $a['detail'] }}</div></div>
                        <span class="pill {{ $a['class'] }}">{{ $a['badge'] }}</span>
                    </div>
                @empty
                    <div class="text-center py-4" style="color:var(--muted)">
                        <i class="bi bi-check-circle" style="font-size:2rem;color:var(--success)"></i>
                        <p class="mb-0 mt-2">Aucune alerte — tout est à jour ✅</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ===================== RECENT CONTRACTS ===================== --}}
<div class="card2">
    <div class="hd"><h5>Derniers contrats</h5><a href="{{ route('contracts.index') }}">Voir tous <i class="bi bi-arrow-right"></i></a></div>
    <div style="padding:8px 4px 4px;overflow-x:auto">
        <table class="t2">
            <thead>
                <tr><th>N°</th><th>Client</th><th>Véhicule</th><th>Départ</th><th>Retour</th><th>Total</th><th>Statut</th></tr>
            </thead>
            <tbody>
                @forelse($recentContracts as $i => $contract)
                    @php
                        [$pillClass, $pillLabel] = $pillMap[$contract->statut->value] ?? ['cours', $contract->statut->value];
                        $prenom = $contract->client?->prenom ?? '';
                        $nom = $contract->client?->nom ?? '—';
                        $initials = strtoupper(mb_substr($prenom, 0, 1) . mb_substr($nom, 0, 1));
                        $color = $avatarColors[$i % count($avatarColors)];
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $contract->numero }}</td>
                        <td>
                            <div class="cust">
                                <span class="av" style="background:{{ $color }}">{{ $initials ?: '—' }}</span>
                                {{ trim($prenom . ' ' . $nom) ?: '—' }}
                            </div>
                        </td>
                        <td>
                            {{ $contract->vehicle?->full_name ?? '—' }}
                            <span class="mut">· {{ $contract->vehicle?->immatriculation }}</span>
                        </td>
                        <td>{{ $contract->date_depart?->format('d/m/Y') }}</td>
                        <td>{{ $contract->date_retour?->format('d/m/Y') }}</td>
                        <td class="fw-semibold nowrap">{{ number_format($contract->total_ttc, 2, ',', ' ') }} DH</td>
                        <td><span class="pill {{ $pillClass }}">{{ $pillLabel }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-5 mut">Aucun contrat trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
  const _line = '#eceef2', _muted = '#6b7280';

  // Revenue area chart
  const rc = document.getElementById('revChart').getContext('2d');
  const grad = rc.createLinearGradient(0, 0, 0, 220);
  grad.addColorStop(0, 'rgba(79,70,229,.25)');
  grad.addColorStop(1, 'rgba(79,70,229,0)');
  new Chart(rc, {
    type: 'line',
    data: {
      labels: @json($revenueSeries->pluck('label')),
      datasets: [{
        data: @json($revenueSeries->pluck('value')),
        borderColor: '#4f46e5', backgroundColor: grad, fill: true,
        tension: .4, borderWidth: 2.5, pointRadius: 4, pointBackgroundColor: '#fff',
        pointBorderColor: '#4f46e5', pointBorderWidth: 2, pointHoverRadius: 6
      }]
    },
    options: {
      plugins: { legend: { display: false },
        tooltip: { callbacks: { label: c => ' ' + c.parsed.y.toLocaleString('fr') + ' DH' } } },
      scales: {
        y: { border: { display: false }, grid: { color: _line },
          ticks: { color: _muted, callback: v => (v / 1000) + 'k' } },
        x: { border: { display: false }, grid: { display: false }, ticks: { color: _muted } }
      }
    }
  });

  // Fleet doughnut
  new Chart(document.getElementById('fleetChart'), {
    type: 'doughnut',
    data: {
      labels: ['Disponibles', 'Loués', 'Maintenance', 'Réservés', 'Hors service'],
      datasets: [{
        data: [{{ $availableVehicles }}, {{ $rentedVehicles }}, {{ $maintenanceVehicles }}, {{ $reservedVehicles }}, {{ $outOfServiceVehicles }}],
        backgroundColor: ['#16a34a', '#4f46e5', '#f59e0b', '#0ea5e9', '#cbd5e1'],
        borderWidth: 0, cutout: '70%'
      }]
    },
    options: { plugins: { legend: { display: false } } }
  });
</script>
@endpush
>>>>>>> origin/location_V_0.2
