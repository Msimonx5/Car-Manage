@extends('layouts.admin')

@section('title', 'Modifier un client')

@section('content')

<div class="page-head">
    <div>
        <h2>Modifier le client</h2>
        <p>{{ $client->prenom }} {{ $client->nom }}</p>
    </div>
    <a href="{{ route('clients.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

@include('components.alerts.errors')

<div class="form-card">
    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')
        @include('clients._form')
    </form>
</div>

@endsection
