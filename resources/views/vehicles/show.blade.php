@extends('layouts.app')

@section('title','Détails du véhicule')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="mb-0">

                {{ $vehicle->full_name }}

            </h3>

            <small class="text-muted">

                {{ $vehicle->immatriculation }}

            </small>

        </div>

        <div>

            <a
                href="{{ route('vehicles.edit',$vehicle) }}"
                class="btn btn-warning">

                Modifier

            </a>

            <a
                href="{{ route('vehicles.index') }}"
                class="btn btn-secondary">

                Retour

            </a>

        </div>

    </div>

    <div class="row">

        <!-- Informations générales -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-primary text-white">

                    Informations générales

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>
                            <th width="45%">Marque</th>
                            <td>{{ $vehicle->marque }}</td>
                        </tr>

                        <tr>
                            <th>Modèle</th>
                            <td>{{ $vehicle->modele }}</td>
                        </tr>

                        <tr>
                            <th>Année</th>
                            <td>{{ $vehicle->annee }}</td>
                        </tr>

                        <tr>
                            <th>Couleur</th>
                            <td>{{ $vehicle->couleur }}</td>
                        </tr>

                        <tr>
                            <th>Immatriculation</th>
                            <td>{{ $vehicle->immatriculation }}</td>
                        </tr>

                        <tr>
                            <th>Numéro châssis</th>
                            <td>{{ $vehicle->numero_chassis ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Numéro moteur</th>
                            <td>{{ $vehicle->numero_moteur ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Carburant</th>
                            <td>{{ $vehicle->carburant }}</td>
                        </tr>

                        <tr>
                            <th>Boîte</th>
                            <td>{{ $vehicle->boite_vitesse }}</td>
                        </tr>

                        <tr>
                            <th>Places</th>
                            <td>{{ $vehicle->nombre_places }}</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <!-- Location -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-success text-white">

                    Informations de location

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <th width="45%">Prix / jour</th>

                            <td>

                                {{ number_format($vehicle->prix_jour,2) }} DH

                            </td>

                        </tr>

                        <tr>

                            <th>Caution</th>

                            <td>

                                {{ number_format($vehicle->caution,2) }} DH

                            </td>

                        </tr>

                        <tr>

                            <th>Statut</th>

                            <td>

                                <x-badge.vehicle-status
                                    :status="$vehicle->statut"/>

                            </td>

                        </tr>

                        <tr>

                            <th>Kilométrage</th>

                            <td>

                                {{ number_format($vehicle->kilometrage,0,',',' ') }}

                                Km

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <!-- Maintenance -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header bg-warning">

                    Suivi maintenance

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <th width="50%">

                                Dernière vidange

                            </th>

                            <td>

                                {{ $vehicle->derniere_vidange_km }}

                                Km

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Date

                            </th>

                            <td>

                                {{ optional($vehicle->derniere_vidange_date)->format('d/m/Y') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Prochaine vidange

                            </th>

                            <td>

                                {{ $vehicle->prochaine_vidange_km }}

                                Km

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Restant

                            </th>

                            <td>

                                {{ number_format($vehicle->remaining_oil_change) }}

                                Km

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Etat

                            </th>

                            <td>

                                <x-badge.oil-change-status
                                    :vehicle="$vehicle"/>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <!-- Assurance -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header bg-info text-white">

                    Documents

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <th width="45%">

                                Assurance

                            </th>

                            <td>

                                {{ optional($vehicle->assurance_expiration)->format('d/m/Y') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Etat

                            </th>

                            <td>

                                <x-badge.insurance-status
                                    :vehicle="$vehicle"/>

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Visite technique

                            </th>

                            <td>

                                {{ optional($vehicle->visite_technique)->format('d/m/Y') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-header">

            Observations

        </div>

        <div class="card-body">

            @if($vehicle->observation)

                {{ $vehicle->observation }}

            @else

                <span class="text-muted">

                    Aucune observation.

                </span>

            @endif

        </div>

    </div>

</div>

@endsection