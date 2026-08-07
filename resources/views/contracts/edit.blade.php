@extends('layouts.app')

@section('title', 'Modifier le contrat')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2>

                        Modifier le contrat

                    </h2>

                    <small class="text-muted">

                        {{ $contract->numero }}

                    </small>

                </div>

                <a
                    href="{{ route('contracts.index') }}"
                    class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>

                    Retour

                </a>

            </div>

        </div>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="card shadow">

        <div class="card-header bg-warning">

            Modifier les informations

        </div>

        <div class="card-body">

            <form
                action="{{ route('contracts.update',$contract) }}"
                method="POST">

                @csrf

                @method('PUT')

                @include('contracts._form')

            </form>

        </div>

    </div>

</div>

@endsection