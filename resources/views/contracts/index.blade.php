@extends('layouts.app')

@section('title', 'Contrats de location')

@section('content')

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <!-- ==========================
            STATISTIQUES
    =========================== -->

    <div class="row mb-4">

        <div class="col-lg-2 col-md-4 mb-3">

            <div class="card border-primary shadow-sm">

                <div class="card-body text-center">

                    <h6>Total</h6>

                    <h2>{{ $stats['total'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4 mb-3">

            <div class="card border-warning shadow-sm">

                <div class="card-body text-center">

                    <h6>En attente</h6>

                    <h2>{{ $stats['en_attente'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4 mb-3">

            <div class="card border-primary shadow-sm">

                <div class="card-body text-center">

                    <h6>En cours</h6>

                    <h2>{{ $stats['en_cours'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4 mb-3">

            <div class="card border-success shadow-sm">

                <div class="card-body text-center">

                    <h6>Terminés</h6>

                    <h2>{{ $stats['termine'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4 mb-3">

            <div class="card border-danger shadow-sm">

                <div class="card-body text-center">

                    <h6>Annulés</h6>

                    <h2>{{ $stats['annule'] }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4 mb-3">

            <div class="card border-success shadow-sm">

                <div class="card-body text-center">

                    <h6>CA</h6>

                    <h5>

                        {{ number_format($stats['chiffre_affaires'],2,',',' ') }}

                        DH

                    </h5>

                </div>

            </div>

        </div>

    </div>

    <!-- ==========================
            RECHERCHE
    =========================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-5">

                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            class="form-control"
                            placeholder="N° contrat, client ou véhicule">

                    </div>

                    <div class="col-md-3">

                        <select
                            name="statut"
                            class="form-select">

                            <option value="">
                                Tous les statuts
                            </option>

                            @foreach(App\Enums\ContractStatus::cases() as $status)

                                <option
                                    value="{{ $status->value }}"
                                    @selected(request('statut')==$status->value)>

                                    {{ $status->label() }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary w-100">

                            Rechercher

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a
                            href="{{ route('contracts.create') }}"
                            class="btn btn-success w-100">

                            Nouveau

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ==========================
            TABLEAU
    =========================== -->

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                    <tr>

                        <th>N°</th>

                        <th>Client</th>

                        <th>Véhicule</th>

                        <th>Départ</th>

                        <th>Retour</th>

                        <th>Durée</th>

                        <th>Total</th>

                        <th>Reste</th>

                        <th>Statut</th>

                        <th>Actions</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($contracts as $contract)

                        <tr>

                            <td>

                                <strong>

                                    {{ $contract->numero }}

                                </strong>

                            </td>

                            <td>

                                {{ $contract->client_full_name }}

                            </td>

                            <td>

                                {{ $contract->vehicle_name }}

                            </td>

                            <td>

                                {{ $contract->date_depart->format('d/m/Y') }}

                            </td>

                            <td>

                                {{ $contract->date_retour->format('d/m/Y') }}

                            </td>

                            <td>

                                {{ $contract->duration }}

                                jours

                                @if($contract->is_expired)

                                    <span class="badge bg-danger ms-1">

                                        Expiré

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $contract->formatted_total }}

                            </td>

                            <td>

                                @if($contract->balance>0)

                                    <span class="text-danger fw-bold">

                                        {{ $contract->formatted_balance }}

                                    </span>

                                @else

                                    <span class="badge bg-success">

                                        Payé

                                    </span>

                                @endif

                            </td>

                            <td>

                                <span class="badge bg-{{ $contract->status_color }}">

                                    {{ $contract->statut->label() }}

                                </span>

                            </td>

                            <td width="220">

                                <a
                                    href="{{ route('contracts.show',$contract) }}"
                                    class="btn btn-info btn-sm">

                                    Voir

                                </a>

                                <a
                                    href="{{ route('contracts.edit',$contract) }}"
                                    class="btn btn-warning btn-sm">

                                    Modifier

                                </a>

                                <form
                                    action="{{ route('contracts.destroy',$contract) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Supprimer ce contrat ?')"
                                        class="btn btn-danger btn-sm">

                                        Supprimer

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="10"
                                class="text-center py-5">

                                Aucun contrat trouvé.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $contracts->links() }}

            </div>

        </div>

    </div>

</div>

@endsection