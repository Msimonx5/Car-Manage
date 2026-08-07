@extends('layouts.app')

@section('title','Détails du client')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between">

            <h4>

                Informations du client

            </h4>

            <a href="{{ route('clients.index') }}"
               class="btn btn-secondary">

                Retour

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="250">Type</th>
                    <td>{{ ucfirst($client->type) }}</td>
                </tr>

                <tr>
                    <th>Nom</th>
                    <td>{{ $client->nom }}</td>
                </tr>

                <tr>
                    <th>Prénom</th>
                    <td>{{ $client->prenom }}</td>
                </tr>

                <tr>
                    <th>Date de naissance</th>
                    <td>{{ $client->date_naissance }}</td>
                </tr>

                <tr>
                    <th>Lieu de naissance</th>
                    <td>{{ $client->lieu_naissance }}</td>
                </tr>

                <tr>
                    <th>Adresse</th>
                    <td>{{ $client->adresse }}</td>
                </tr>

                <tr>
                    <th>CIN</th>
                    <td>{{ $client->cin }}</td>
                </tr>

                <tr>
                    <th>Nationalité</th>
                    <td>{{ $client->nationalite }}</td>
                </tr>

                <tr>
                    <th>Permis</th>
                    <td>{{ $client->numero_permis }}</td>
                </tr>

                <tr>
                    <th>Passeport</th>
                    <td>{{ $client->numero_passeport ?: '-' }}</td>
                </tr>

                <tr>
                    <th>Adresse à l'étranger</th>
                    <td>{{ $client->adresse_etranger ?: '-' }}</td>
                </tr>

                <tr>
                    <th>Téléphone</th>
                    <td>{{ $client->telephone }}</td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection