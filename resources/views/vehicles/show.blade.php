@extends('layouts.admin')

@section('title', 'Détails du véhicule')

@section('content')

<div class="page-head">
    <div>
        <h2>{{ $vehicle->full_name }}</h2>
        <p>{{ $vehicle->immatriculation }} · <x-badge.vehicle-status :status="$vehicle->statut"/></p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('vehicles.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn-brand"><i class="bi bi-pencil"></i> Modifier</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="form-card h-100">
            <div class="section-title" style="margin-top:2px"><i class="bi bi-car-front"></i> Informations générales</div>
            <table class="detail">
                <tr><th>Marque</th><td>{{ $vehicle->marque }}</td></tr>
                <tr><th>Modèle</th><td>{{ $vehicle->modele }}</td></tr>
                <tr><th>Année</th><td>{{ $vehicle->annee }}</td></tr>
                <tr><th>Couleur</th><td>{{ $vehicle->couleur ?: '—' }}</td></tr>
                <tr><th>Immatriculation</th><td>{{ $vehicle->immatriculation }}</td></tr>
                <tr><th>N° Châssis</th><td>{{ $vehicle->numero_chassis ?: '—' }}</td></tr>
                <tr><th>N° Moteur</th><td>{{ $vehicle->numero_moteur ?: '—' }}</td></tr>
                <tr><th>Carburant</th><td>{{ $vehicle->carburant }}</td></tr>
                <tr><th>Boîte</th><td>{{ $vehicle->boite_vitesse }}</td></tr>
                <tr><th>Places</th><td>{{ $vehicle->nombre_places }}</td></tr>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-card h-100">
            <div class="section-title" style="margin-top:2px"><i class="bi bi-cash-coin"></i> Location</div>
            <table class="detail">
                <tr><th>Prix / jour</th><td class="fw-semibold">{{ number_format($vehicle->prix_jour, 2, ',', ' ') }} DH</td></tr>
                <tr><th>Caution</th><td>{{ number_format($vehicle->caution, 2, ',', ' ') }} DH</td></tr>
                <tr><th>Statut</th><td><x-badge.vehicle-status :status="$vehicle->statut"/></td></tr>
                <tr><th>Kilométrage</th><td>{{ number_format($vehicle->kilometrage, 0, ',', ' ') }} Km</td></tr>
            </table>

            <div class="section-title"><i class="bi bi-shield-check"></i> Documents</div>
            <table class="detail">
                <tr><th>Assurance</th><td>{{ optional($vehicle->assurance_expiration)->format('d/m/Y') ?: '—' }} &nbsp; <x-badge.insurance-status :vehicle="$vehicle"/></td></tr>
                <tr><th>Visite technique</th><td>{{ optional($vehicle->visite_technique)->format('d/m/Y') ?: '—' }}</td></tr>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-card h-100">
            <div class="section-title" style="margin-top:2px"><i class="bi bi-tools"></i> Suivi maintenance</div>
            <table class="detail">
                <tr><th>Dernière vidange</th><td>{{ $vehicle->derniere_vidange_km ? number_format($vehicle->derniere_vidange_km, 0, ',', ' ') . ' Km' : '—' }}</td></tr>
                <tr><th>Date</th><td>{{ optional($vehicle->derniere_vidange_date)->format('d/m/Y') ?: '—' }}</td></tr>
                <tr><th>Dernier remplissage AdBlue</th><td>{{ optional($vehicle->adblue_date)->format('d/m/Y') ?: '—' }}</td></tr>
                <tr><th>Prochaine vidange</th><td>{{ $vehicle->prochaine_vidange_km ? number_format($vehicle->prochaine_vidange_km, 0, ',', ' ') . ' Km' : '—' }}</td></tr>
                <tr><th>Restant</th><td>{{ number_format($vehicle->remaining_oil_change, 0, ',', ' ') }} Km &nbsp; <x-badge.oil-change-status :vehicle="$vehicle"/></td></tr>
                @foreach([
                    'filtre_air_date' => 'Filtre à air',
                    'filtre_huile_date' => 'Filtre à huile',
                    'filtre_carburant_date' => 'Filtre à carburant',
                    'filtre_habitacle_date' => 'Chaîne de distribution',
                ] as $field => $label)
                    <tr><th>{{ $label }}</th><td>{{ $vehicle->{$field} ? 'Changé le ' . $vehicle->{$field}->format('d/m/Y') : 'Pas encore renseigné' }}</td></tr>
                @endforeach
                <tr><th>Pneus</th><td>{{ $vehicle->pneus_description ?: '—' }}{{ $vehicle->pneus_date ? ' — le ' . $vehicle->pneus_date->format('d/m/Y') : '' }}</td></tr>
                <tr><th>Plaquettes de frein</th><td>{{ $vehicle->plaquettes_frein_description ?: '—' }}{{ $vehicle->plaquettes_frein_date ? ' — le ' . $vehicle->plaquettes_frein_date->format('d/m/Y') : '' }}</td></tr>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-card h-100">
            <div class="section-title" style="margin-top:2px"><i class="bi bi-chat-left-text"></i> Observation</div>
            <p style="font-size:13.5px;margin:0;{{ $vehicle->observation ? '' : 'color:var(--muted)' }}">
                {{ $vehicle->observation ?: 'Aucune observation.' }}
            </p>
        </div>
    </div>
</div>

@endsection
