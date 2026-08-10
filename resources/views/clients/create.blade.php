@extends('layouts.admin')

@section('title', 'Ajouter un client')

@section('content')

<div class="page-head">
    <div>
        <h2>Nouveau client</h2>
        <p>Renseignez les informations du client</p>
    </div>
    <a href="{{ route('clients.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

@include('components.alerts.errors')

<div class="form-card">
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        @include('clients._form')
    </form>
</div>

@endsection
