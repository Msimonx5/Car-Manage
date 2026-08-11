@extends('layouts.admin')

@section('title', 'Nouveau véhicule')

@section('content')

<div class="page-head">
    <div>
        <h2>Nouveau véhicule</h2>
        <p>Ajoutez un véhicule à la flotte</p>
    </div>
    <a href="{{ route('vehicles.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

@include('components.alerts.errors')

<div class="form-card">
    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf
        @include('vehicles._form')
    </form>
</div>

@endsection
