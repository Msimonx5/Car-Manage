@extends('layouts.app')

@section('title', 'Liste des clients')

@section('content')

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                Liste des clients
            </h4>

            <a href="{{ route('clients.create') }}"
               class="btn btn-primary">

                Nouveau client

            </a>

        </div>

        <div class="card-body">

            @if($clients->isEmpty())

                <div class="alert alert-info mb-0">

                    Aucun client trouvé.

                </div>

            @else

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Type</th>

                            <th>Nom</th>

                            <th>Prénom</th>

                            <th>CIN</th>

                            <th>Permis</th>

                            <th>Téléphone</th>

                            <th width="220">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($clients as $client)

                        <tr>

                            <td>{{ $client->id }}</td>

                            <td>

                                <span class="badge bg-secondary">

                                    {{ ucfirst($client->type) }}

                                </span>

                            </td>

                            <td>{{ $client->nom }}</td>

                            <td>{{ $client->prenom }}</td>

                            <td>{{ $client->cin }}</td>

                            <td>{{ $client->numero_permis }}</td>

                            <td>{{ $client->telephone }}</td>

                            <td>

                                <a href="{{ route('clients.show',$client) }}"
                                   class="btn btn-info btn-sm">

                                    Voir

                                </a>

                                <a href="{{ route('clients.edit',$client) }}"
                                   class="btn btn-warning btn-sm">

                                    Modifier

                                </a>

                                <form
                                    action="{{ route('clients.destroy',$client) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Supprimer ce client ?')"
                                        class="btn btn-danger btn-sm">

                                        Supprimer

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $clients->links() }}

            </div>

            @endif

        </div>

    </div>

</div>

@endsection