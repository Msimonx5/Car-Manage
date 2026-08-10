@extends('layouts.admin')

@section('title', 'Nouveau contrat')

@section('content')

<div class="page-head">
    <div>
        <h2>Nouveau contrat de location</h2>
        <p>Créez un contrat en liant un client et un véhicule</p>
    </div>
    <a href="{{ route('contracts.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

@include('components.alerts.errors')

<div class="form-card">
    <form action="{{ route('contracts.store') }}" method="POST">
        @csrf
        @include('contracts._form')
    </form>
</div>

@endsection
