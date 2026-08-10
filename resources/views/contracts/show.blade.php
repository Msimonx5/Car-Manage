@extends('layouts.admin')

@section('title', 'Contrat ' . $contract->numero)

@section('content')

<div class="page-head">
    <div>
        <h2>Contrat {{ $contract->numero }}</h2>
        <p><span class="pill {{ $contract->status_color }}">{{ $contract->statut->label() }}</span></p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('contracts.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
        <a href="{{ route('contracts.pdf', $contract) }}" target="_blank" class="btn-soft"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
        <a href="{{ route('contracts.download', $contract) }}" class="btn-soft"><i class="bi bi-download"></i> Télécharger</a>
        <a href="{{ route('contracts.edit', $contract) }}" class="btn-brand"><i class="bi bi-pencil"></i> Modifier</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="form-card h-100">
            <div class="section-title" style="margin-top:2px"><i class="bi bi-person"></i> Client</div>
            <table class="detail">
                <tr><th>Nom complet</th><td>{{ $contract->client_full_name }}</td></tr>
                <tr><th>C.I.N</th><td>{{ $contract->client?->cin ?: '—' }}</td></tr>
                <tr><th>Téléphone</th><td>{{ $contract->client?->telephone ?: '—' }}</td></tr>
                <tr><th>Deuxième conducteur</th><td>{{ $contract->secondDriver ? $contract->secondDriver->nom . ' ' . $contract->secondDriver->prenom : '—' }}</td></tr>
            </table>

            <div class="section-title"><i class="bi bi-car-front"></i> Véhicule</div>
            <table class="detail">
                <tr><th>Véhicule</th><td>{{ $contract->vehicle_name }}</td></tr>
                <tr><th>Immatriculation</th><td>{{ $contract->vehicle?->immatriculation ?: '—' }}</td></tr>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-card h-100">
            <div class="section-title" style="margin-top:2px"><i class="bi bi-calendar-range"></i> Période</div>
            <table class="detail">
                <tr><th>Départ</th><td>{{ $contract->date_depart->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($contract->heure_depart)->format('H:i') }}</td></tr>
                <tr><th>Retour</th><td>{{ $contract->date_retour->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($contract->heure_retour)->format('H:i') }}
                    @if($contract->is_expired)<span class="pill danger" style="margin-left:6px">Expiré</span>@endif</td></tr>
                <tr><th>Durée</th><td>{{ $contract->duration }} jour(s)</td></tr>
                <tr><th>Km départ / retour</th><td>{{ $contract->km_depart }} / {{ $contract->km_retour ?: '—' }}</td></tr>
            </table>

            <div class="section-title"><i class="bi bi-receipt"></i> Frais</div>
            <table class="detail">
                <tr><th>Tarif / jour</th><td>{{ number_format($contract->tarif_jour, 2, ',', ' ') }} DH</td></tr>
                <tr><th>Caution</th><td>{{ number_format($contract->caution, 2, ',', ' ') }} DH</td></tr>
                <tr><th>Avance</th><td>{{ number_format($contract->avance, 2, ',', ' ') }} DH</td></tr>
                <tr><th>Total HT</th><td>{{ number_format($contract->total_ht, 2, ',', ' ') }} DH</td></tr>
                <tr><th>TVA (20%)</th><td>{{ number_format($contract->tva, 2, ',', ' ') }} DH</td></tr>
                <tr><th>Total TTC</th><td class="fw-semibold" style="color:var(--primary)">{{ number_format($contract->total_ttc, 2, ',', ' ') }} DH</td></tr>
                <tr><th>Mode de règlement</th><td>{{ $contract->mode_paiement ?: '—' }}</td></tr>
            </table>
        </div>
    </div>

    <div class="col-12">
        <div class="form-card">
            <div class="section-title" style="margin-top:2px"><i class="bi bi-chat-left-text"></i> Observation</div>
            <p style="font-size:13.5px;margin:0;{{ $contract->observation ? '' : 'color:var(--muted)' }}">
                {{ $contract->observation ?: 'Aucune observation.' }}
            </p>
        </div>
    </div>
</div>

@endsection
