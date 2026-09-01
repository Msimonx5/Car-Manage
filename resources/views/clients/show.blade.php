@extends('layouts.admin')

@section('title', 'Détails du client')

@section('content')

@php $initials = strtoupper(mb_substr($client->prenom, 0, 1) . mb_substr($client->nom, 0, 1)); @endphp

<div class="page-head">
    <div>
        <h2>Fiche client</h2>
        <p>{{ $client->prenom }} {{ $client->nom }}</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('clients.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
        <a href="{{ route('clients.edit', $client) }}" class="btn-brand"><i class="bi bi-pencil"></i> Modifier</a>
    </div>
</div>

<div class="form-card">
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:6px">
        <span class="av" style="width:52px;height:52px;border-radius:14px;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700;font-size:18px">{{ $initials }}</span>
        <div>
            <div style="font-size:18px;font-weight:700">{{ $client->prenom }} {{ $client->nom }}</div>
            <span class="pill {{ $client->type == 'principal' ? 'primary' : 'secondary' }}">{{ ucfirst($client->type) }}</span>
        </div>
    </div>

    <div class="section-title"><i class="bi bi-person-vcard"></i> Identité</div>
    <table class="detail">
        <tr><th>Nom complet</th><td>{{ $client->prenom }} {{ $client->nom }}</td></tr>
        <tr><th>Date de naissance</th><td>{{ optional($client->date_naissance)->format('d/m/Y') ?: '—' }}</td></tr>
        <tr><th>Lieu de naissance</th><td>{{ $client->lieu_naissance ?: '—' }}</td></tr>
        <tr><th>Nationalité</th><td>{{ $client->nationalite ?: '—' }}</td></tr>
    </table>

    <div class="section-title"><i class="bi bi-card-heading"></i> Documents</div>
    <table class="detail">
        <tr><th>N° C.I.N</th><td>{{ $client->cin }}</td></tr>
        <tr><th>N° Permis</th><td>{{ $client->numero_permis }}</td></tr>
        <tr><th>N° Passeport</th><td>{{ $client->numero_passeport ?: '—' }}</td></tr>
    </table>

    <div class="section-title"><i class="bi bi-geo-alt"></i> Coordonnées</div>
    <table class="detail">
        <tr><th>Téléphone</th><td>{{ $client->telephone }}</td></tr>
        <tr><th>Email</th><td>{{ $client->email }}</td></tr>
        <tr><th>Adresse</th><td>{{ $client->adresse ?: '—' }}</td></tr>
        <tr><th>Ville</th><td>{{ $client->ville ?: '—' }}</td></tr>
        <tr><th>Adresse à l'étranger</th><td>{{ $client->adresse_etranger ?: '—' }}</td></tr>
    </table>
</div>

@endsection
