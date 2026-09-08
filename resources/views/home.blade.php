@extends('layouts.app')

@section('title','Accueil')

@section('content')

<div class="row">

    <div class="col-lg-12">

        <div class="p-5 mb-4 bg-white rounded shadow-sm">

            <h1 class="display-5">

                🚗 SOULAMI CAR

            </h1>

            <p class="lead">

                Système de gestion de location de véhicules.

            </p>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h5>

                    Clients

                </h5>

                <a
                    href="{{ route('clients.index') }}"
                    class="btn btn-primary mt-3">

                    Gérer

                </a>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h5>

                    Véhicules

                </h5>

                <a
                    href="{{ route('vehicles.index') }}"
                    class="btn btn-success mt-3">

                    Gérer

                </a>

            </div>

        </div>

    </div>

@can('view-contracts')
    <div class="col-md-3 mb-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h5>

                    Contrats

                </h5>

                <a
                    href="{{ route('contracts.index') }}"
                    class="btn btn-warning mt-3">

                    Gérer

                </a>

            </div>

        </div>

    </div>
@endcan

    <div class="col-md-3 mb-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h5>

                    Tableau de bord

                </h5>

                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-dark mt-3">

                    Ouvrir

                </a>

            </div>

        </div>

    </div>

</div>

@endsection