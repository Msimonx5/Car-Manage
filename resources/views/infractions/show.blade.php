@extends('layouts.admin')

@section('title', 'Infraction ' . ($infraction->reference ?? '#' . $infraction->id))

@section('content')

<div class="page-head">

```
<div>

    <h2>
        Infraction {{ $infraction->reference ?? '#' . $infraction->id }}
    </h2>

    <p>
        @php
            $statusClass = match($infraction->statut) {
                'en_attente' => 'warning',
                'reglee' => 'success',
                'annulee' => 'danger',
                default => 'secondary',
            };

            $statusLabel = match($infraction->statut) {
                'en_attente' => 'En attente',
                'reglee' => 'Réglée',
                'annulee' => 'Annulée',
                default => ucfirst(str_replace('_', ' ', $infraction->statut)),
            };
        @endphp

        <span class="pill {{ $statusClass }}">
            {{ $statusLabel }}
        </span>
    </p>

</div>


<div style="display:flex;gap:10px;flex-wrap:wrap">

    <a
        href="{{ route('infractions.index') }}"
        class="btn-soft"
    >
        <i class="bi bi-arrow-left"></i>
        Retour
    </a>

    <a
        href="{{ route('infractions.edit', $infraction) }}"
        class="btn-brand"
    >
        <i class="bi bi-pencil"></i>
        Modifier
    {{-- </a>
        <a href="{{ route('infractions.pdf.preview', $infraction) }}" target="_blank" class="btn btn-light">
        <i class="bi bi-eye"></i> Aperçu
    </a>

    <a href="{{ route('infractions.pdf.download', $infraction) }}" class="btn-brand">
        <i class="bi bi-download"></i> Télécharger
    </a> --}}

</div>
```

</div>

<div class="row g-3">

```
{{-- CLIENT --}}

<div class="col-lg-6">

    <div class="form-card h-100">

        <div
            class="section-title"
            style="margin-top:2px"
        >
            <i class="bi bi-person"></i>
            Client
        </div>

        <table class="detail">

            <tr>
                <th>Nom complet</th>
                <td>
                    {{ $infraction->client?->nom ?? $infraction->nom }}
                    {{ $infraction->client?->prenom ?? $infraction->prenom }}
                </td>
            </tr>

            <tr>
                <th>C.I.N</th>
                <td>
                    {{ $infraction->client?->cin ?? $infraction->cin ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>N° permis</th>
                <td>
                    {{ $infraction->client?->numero_permis ?? $infraction->numero_permis ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>Téléphone</th>
                <td>
                    {{ $infraction->client?->telephone ?? $infraction->telephone ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>Email</th>
                <td>
                    {{ $infraction->client?->email ?? $infraction->email ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>Adresse</th>
                <td>
                    {{ $infraction->client?->adresse ?? $infraction->adresse ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>Ville</th>
                <td>
                    {{ $infraction->client?->ville ?? $infraction->ville ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>Code postal</th>
                <td>
                    {{ $infraction->client?->code_postal ?? $infraction->code_postal ?: '—' }}
                </td>
            </tr>

        </table>


        {{-- VÉHICULE --}}

        <div class="section-title">

            <i class="bi bi-car-front"></i>
            Véhicule

        </div>

        <table class="detail">

            <tr>
                <th>Véhicule</th>
                <td>

                    @if($infraction->vehicle)

                        {{ $infraction->vehicle->marque }}
                        {{ $infraction->vehicle->modele }}

                    @else

                        {{ $infraction->marque }}
                        {{ $infraction->modele }}

                    @endif

                </td>
            </tr>

            <tr>
                <th>Immatriculation</th>
                <td>
                    {{ $infraction->vehicle?->immatriculation ?? $infraction->immatriculation ?: '—' }}
                </td>
            </tr>

        </table>

    </div>

</div>


{{-- INFRACTION + CONTRAT --}}

<div class="col-lg-6">

    <div class="form-card h-100">


        {{-- INFRACTION --}}

        <div
            class="section-title"
            style="margin-top:2px"
        >

            <i class="bi bi-exclamation-triangle"></i>
            Infraction

        </div>

        <table class="detail">

            <tr>
                <th>Référence / N° PV</th>
                <td>
                    {{ $infraction->reference ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>Date</th>
                <td>

                    @if($infraction->date_infraction)

                        {{ $infraction->date_infraction->format('d/m/Y') }}

                    @else

                        —

                    @endif

                </td>
            </tr>

            <tr>
                <th>Heure</th>
                <td>
                    {{ $infraction->heure_infraction
                        ? \Carbon\Carbon::parse($infraction->heure_infraction)->format('H:i')
                        : '—'
                    }}
                </td>
            </tr>

            <tr>
                <th>Lieu</th>
                <td>
                    {{ $infraction->lieu ?: '—' }}
                </td>
            </tr>

            <tr>
                <th>Montant</th>
                <td>

                    @if($infraction->montant !== null)

                        <span
                            class="fw-semibold"
                            style="color:var(--primary)"
                        >
                            {{ number_format($infraction->montant, 2, ',', ' ') }}
                            DH
                        </span>

                    @else

                        —

                    @endif

                </td>
            </tr>

            <tr>
                <th>Statut</th>
                <td>

                    <span class="pill {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>

                </td>
            </tr>

        </table>


        {{-- CONTRAT --}}

        <div class="section-title">

            <i class="bi bi-file-earmark-text"></i>
            Contrat de location

        </div>

        <table class="detail">

            <tr>
                <th>N° contrat</th>
                <td>

                    @if($infraction->contract)

                        <a
                            href="{{ route('contracts.show', $infraction->contract) }}"
                            style="font-weight:600;color:var(--primary);text-decoration:none"
                        >
                            {{ $infraction->contract->numero }}
                        </a>

                    @else

                        {{ $infraction->numero_contrat ?: '—' }}

                    @endif

                </td>
            </tr>

            <tr>
                <th>Départ</th>
                <td>

                    @if($infraction->date_depart)

                        {{ $infraction->date_depart->format('d/m/Y') }}

                        @if($infraction->heure_depart)

                            à
                            {{ \Carbon\Carbon::parse($infraction->heure_depart)->format('H:i') }}

                        @endif

                    @else

                        —

                    @endif

                </td>
            </tr>

            <tr>
                <th>Retour</th>
                <td>

                    @if($infraction->date_retour)

                        {{ $infraction->date_retour->format('d/m/Y') }}

                        @if($infraction->heure_retour)

                            à
                            {{ \Carbon\Carbon::parse($infraction->heure_retour)->format('H:i') }}

                        @endif

                    @else

                        —

                    @endif

                </td>
            </tr>

        </table>

    </div>

</div>


{{-- DESCRIPTION --}}

<div class="col-12">

    <div class="form-card">

        <div
            class="section-title"
            style="margin-top:2px"
        >
            <i class="bi bi-file-text"></i>
            Description
        </div>

        <p
            style="
                font-size:13.5px;
                margin:0;
                {{ $infraction->description ? '' : 'color:var(--muted)' }}
            "
        >
            {{ $infraction->description ?: 'Aucune description.' }}
        </p>

    </div>

</div>


{{-- OBSERVATION --}}

<div class="col-12">

    <div class="form-card">

        <div
            class="section-title"
            style="margin-top:2px"
        >
            <i class="bi bi-chat-left-text"></i>
            Observation
        </div>

        <p
            style="
                font-size:13.5px;
                margin:0;
                {{ $infraction->observation ? '' : 'color:var(--muted)' }}
            "
        >
            {{ $infraction->observation ?: 'Aucune observation.' }}
        </p>

    </div>

</div>


{{-- INFORMATIONS SYSTÈME --}}

<div class="col-12">

    <div class="form-card">

        <div
            class="section-title"
            style="margin-top:2px"
        >
            <i class="bi bi-info-circle"></i>
            Informations
        </div>

        <table class="detail">

            <tr>
                <th>Créée le</th>
                <td>
                    {{ $infraction->created_at?->format('d/m/Y à H:i') ?? '—' }}
                </td>
            </tr>

            <tr>
                <th>Dernière modification</th>
                <td>
                    {{ $infraction->updated_at?->format('d/m/Y à H:i') ?? '—' }}
                </td>
            </tr>

        </table>

    </div>

</div>
```

</div>

@endsection
