@extends('layouts.admin')

@section('title', 'Modifier un véhicule')

@section('content')

<div class="page-head">
    <div>
        <h2>Modifier le véhicule</h2>
        <p>{{ $vehicle->marque }} {{ $vehicle->modele }} · {{ $vehicle->immatriculation }}</p>
    </div>
    <a href="{{ route('vehicles.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

@include('components.alerts.errors')

<div class="form-card">
    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
        @csrf
        @method('PUT')
        @include('vehicles._form')
    </form>
</div>

@endsection
