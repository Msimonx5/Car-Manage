@extends('layouts.app')

@section('title', 'Nouveau contrat')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>

                    Nouveau contrat de location

                </h2>

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

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            Informations du contrat

        </div>

        <div class="card-body">

            <form
                action="{{ route('contracts.store') }}"
                method="POST">

                @csrf

                @include('contracts._form')

            </form>

        </div>

    </div>

</div>

@endsection