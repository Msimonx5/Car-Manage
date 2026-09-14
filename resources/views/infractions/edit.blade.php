@extends('layouts.admin')

@section('title', 'Nouveau Infraction')

@section('content')

<div class="page-head">
    <div>
        <h2>Nouvelle Infraction</h2>
        <p>Créez une infraction en liant un client et un véhicule</p>
    </div>
    <a href="{{ route('infractions.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

@include('components.alerts.errors')

<div class="form-card">
    <form action="{{ route('infractions.update', $infraction->id) }}" method="PUT">
        @csrf
        @method('PUT')
        @include($usesContracts ? 'infractions._form' : 'infractions._form-without-contract')
    </form>
</div>

@endsection
