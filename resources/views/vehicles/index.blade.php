@extends('layouts.app')

@section('title','Gestion des véhicules')

@section('content')

<div class="container-fluid">

    @include('components.alerts.success')

    <div class="row mb-4">

        <div class="col-md-2">

            <div class="card border-primary">

                <div class="card-body text-center">

                    <h5>Total</h5>

                    <h2>{{ $stats['total'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-2">

            <div class="card border-success">

                <div class="card-body text-center">

                    <h5>Disponibles</h5>

                    <h2>{{ $stats['disponible'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-2">

            <div class="card border-warning">

                <div class="card-body text-center">

                    <h5>Maintenance</h5>

                    <h2>{{ $stats['maintenance'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-2">

            <div class="card border-danger">

                <div class="card-body text-center">

                    <h5>Vidanges</h5>

                    <h2>{{ $stats['vidange_urgente'] }}</h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-header">

            <div class="row">

                <div class="col-md-9">

                    <form method="GET">

                        <div class="row">

                            <div class="col-md-4">

                                <input
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
                                    class="form-control"
                                    placeholder="Marque, modèle ou immatriculation">

                            </div>

                            <div class="col-md-3">

                                <select
                                    name="statut"
                                    class="form-select">

                                    <option value="">

                                        Tous les statuts

                                    </option>

                                    @foreach(App\Enums\VehicleStatus::cases() as $status)

                                        <option
                                            value="{{ $status->value }}"
                                            @selected(request('statut')==$status->value)>

                                            {{ $status->label() }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-3">

                                <select
                                    name="sort"
                                    class="form-select">

                                    <option value="latest">

                                        Plus récents

                                    </option>

                                    <option value="marque">

                                        Marque

                                    </option>

                                    <option value="kilometrage">

                                        Kilométrage

                                    </option>

                                    <option value="prix">

                                        Prix

                                    </option>

                                </select>

                            </div>

                            <div class="col-md-2">

                                <button
                                    class="btn btn-primary w-100">

                                    Rechercher

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="col-md-3 text-end">

                    <a
                        href="{{ route('vehicles.create') }}"
                        class="btn btn-success">

                        Nouveau véhicule

                    </a>

                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                    <tr>

                        <th>#</th>

                        <th>Immatriculation</th>

                        <th>Véhicule</th>

                        <th>Km</th>

                        <th>Prix/Jour</th>

                        <th>Statut</th>

                        <th>Vidange</th>

                        <th>Assurance</th>

                        <th width="220">

                            Actions

                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($vehicles as $vehicle)

                    <tr>

                        <td>

                            {{ $vehicle->id }}

                        </td>

                        <td>

                            {{ $vehicle->immatriculation }}

                        </td>

                        <td>

                            <strong>

                                {{ $vehicle->full_name }}

                            </strong>

                        </td>

                        <td>

                            {{ number_format($vehicle->kilometrage,0,',',' ') }}

                        </td>

                        <td>

                            {{ number_format($vehicle->prix_jour,2) }}

                        </td>

                        <td>

                            <x-badge.vehicle-status
                                :status="$vehicle->statut"/>

                        </td>

                        <td>

                            <x-badge.oil-change-status
                                :vehicle="$vehicle"/>

                        </td>

                        <td>

                            <x-badge.insurance-status
                                :vehicle="$vehicle"/>

                        </td>

                        <td>

                            <a
                                href="{{ route('vehicles.show',$vehicle) }}"
                                class="btn btn-info btn-sm">

                                Voir

                            </a>

                            <a
                                href="{{ route('vehicles.edit',$vehicle) }}"
                                class="btn btn-warning btn-sm">

                                Modifier

                            </a>

                            <form
                                action="{{ route('vehicles.destroy',$vehicle) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                @method('DELETE')

                                <button
                                    onclick="return confirm('Supprimer ce véhicule ?')"
                                    class="btn btn-danger btn-sm">

                                    Supprimer

                                </button>

                            </form>

                        </td>

                    </tr>
                    <form action="{{ route('vehicles.oil-change', $vehicle) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="btn btn-warning">
                            Effectuer la vidange (+10 000 km)
                        </button>
                    </form>

                    @empty

                    <tr>

                        <td
                            colspan="9"
                            class="text-center">

                            Aucun véhicule trouvé.

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $vehicles->links() }}

            </div>

        </div>

    </div>

</div>

@endsection