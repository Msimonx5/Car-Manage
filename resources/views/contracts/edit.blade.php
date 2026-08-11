@extends('layouts.admin')

@section('title', 'Modifier le contrat')

@section('content')

<div class="page-head">
    <div>
        <h2>Modifier le contrat</h2>
        <p>{{ $contract->numero }}</p>
    </div>
    <a href="{{ route('contracts.index') }}" class="btn-soft"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

@include('components.alerts.errors')

<div class="form-card">
    <form action="{{ route('contracts.update', $contract) }}" method="POST">
        @csrf
        @method('PUT')
        @include('contracts._form')
    </form>
</div>

@endsection
