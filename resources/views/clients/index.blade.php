@extends('layouts.admin')

@section('title', 'Clients')

@section('content')

@php $avatarColors = ['#4f46e5','#0ea5e9','#16a34a','#f59e0b','#8b5cf6','#ef4444']; @endphp

<div class="page-head">
    <div>
        <h2>Clients</h2>
        <p>{{ $clients->total() }} client(s) enregistré(s)</p>
    </div>
    <a href="{{ route('clients.create') }}" class="btn-brand"><i class="bi bi-plus-lg"></i> Nouveau client</a>
</div>

@if(session('success'))
    <div class="flash ok"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>
@endif

<div class="card2">
     <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nom, prénom, CIN ou téléphone">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">Tous les types</option>
                    <option value="principal" @selected(request('type')=='principal')>Principal</option>
                    <option value="secondaire" @selected(request('type')=='secondaire')>Secondaire</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="latest" @selected(request('sort')=='latest')>Plus récents</option>
                    <option value="nom" @selected(request('sort')=='nom')>Nom</option>
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
                <tr><th>#</th><th>Type</th><th>Client</th><th>CIN</th><th>Permis</th><th>Téléphone</th><th style="text-align:right">Actions</th></tr>
            </thead>
            <tbody>
                @forelse($clients as $i => $client)
                    @php
                        $color = $avatarColors[$i % count($avatarColors)];
                        $initials = strtoupper(mb_substr($client->prenom, 0, 1) . mb_substr($client->nom, 0, 1));
                    @endphp
                    <tr>
                        <td class="mut">{{ $client->id }}</td>
                        <td><span class="pill {{ $client->type == 'principal' ? 'primary' : 'secondary' }}">{{ ucfirst($client->type) }}</span></td>
                        <td>
                            <div class="cust">
                                <span class="av" style="background:{{ $color }}">{{ $initials }}</span>
                                {{ $client->prenom }} {{ $client->nom }}
                            </div>
                        </td>
                        <td>{{ $client->cin }}</td>
                        <td>{{ $client->numero_permis }}</td>
                        <td>{{ $client->telephone }}</td>
                        <td style="text-align:right;white-space:nowrap">
                            <a href="{{ route('clients.show', $client) }}" class="act view" title="Voir"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('clients.edit', $client) }}" class="act edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce client ?')">
                                @csrf @method('DELETE')
                                <button class="act danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-5 mut">Aucun client trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $clients->links() }}</div>

@endsection
