<!--
  CONTRAT DE LOCATION - BODY (body.blade.php)
  ---------------------------------------------------------------
  - Compatible DomPDF : uniquement des tableaux HTML (pas de flex/grid).
  - Le header (image) est géré séparément dans header.blade.php.
  - Toutes les variables utilisées viennent de $contract, $contract->client,
    $contract->secondDriver, $contract->createdBy, $contract->vehicle.
  - NOTE : les propriétés du véhicule (marque, immatriculation) n'étaient pas
    listées dans les variables fournies. J'ai supposé $contract->vehicle->marque
    et $contract->vehicle->immatriculation — adapte ces deux lignes si les noms
    réels diffèrent dans ton modèle Vehicle.
-->

<style>
    .contrat-body {
        font-family: DejaVu Sans, Arial, sans-serif;
        font-size: 12px;
        color: #111;
        width: 100%;
    }

    .top-info-table {
        width: 100%;
        margin-bottom: 10px;
    }

    .top-info-table td {
        font-size: 12px;
        vertical-align: middle;
    }

    .numero-cell {
        font-weight: bold;
    }

    .statut-cell {
        text-align: center;
        font-weight: bold;
        border: 1px solid #000;
        border-radius: 10px;
        padding: 3px 10px;
    }

    .date-cell {
        text-align: right;
        font-style: italic;
    }

    .grid-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 10px;
    }

    .grid-table > tbody > tr > td {
        width: 50%;
        vertical-align: top;
        padding: 0;
    }

    .box {
        border: 1.5px solid #000;
        border-radius: 14px;
        padding: 10px 14px 14px 14px;
    }

    .box-title {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .field-table {
        width: 100%;
        border-collapse: collapse;
    }

    .field-table td {
        padding: 3px 0;
        font-size: 12px;
        vertical-align: bottom;
    }

    .field-label {
        white-space: nowrap;
        font-weight: bold;
        padding-right: 6px;
    }

    .field-value {
        width: 100%;
        border-bottom: 1px dotted #555;
    }

    .no-second-driver {
        text-align: center;
        font-style: italic;
        color: #555;
        padding: 20px 0;
    }

    .bottom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 10px;
        margin-top: 0;
    }

    .bottom-table > tbody > tr > td {
        width: 50%;
        vertical-align: top;
    }

    .accept-text {
        text-align: center;
        font-size: 11px;
        font-weight: bold;
        padding: 8px 10px;
        border-bottom: 1px solid #000;
    }

    .signature-row {
        padding: 10px;
        border-bottom: 1px solid #000;
        font-weight: bold;
    }

    .signature-row:last-child {
        border-bottom: none;
    }

    .observation-cell {
        padding: 10px;
        font-weight: bold;
    }
</style>


<div class="contrat-body">

    <!-- Numéro de contrat / statut / date -->
    <table class="top-info-table">
        <tr>
            <td class="numero-cell">Contrat N° : {{ $contract->numero ?? '-' }}</td>
            <td class="statut-cell">
                @php
                    $status = match($contract->statut->value ?? $contract->statut) {
                        'en_attente' => 'En attente',
                        'en_cours' => 'En cours',
                        'termine' => 'Terminé',
                        'annule' => 'Annulé',
                        default => '-'
                    };
                @endphp
                {{ $status }}
            </td>
            <td class="date-cell">Khouribga Le : {{ $contract->created_at->format('d/m/Y') ?? '-' }}</td>
        </tr>
    </table>

    <table class="grid-table">
        <tr>
            <!-- CLIENT -->
            <td>
                <div class="box">
                    <div class="box-title">Client</div>
                    <table class="field-table">
                        <tr><td class="field-label">NOM :</td><td class="field-value">{{ $contract->client->nom ?? '-' }}</td></tr>
                        <tr><td class="field-label">PRENOM :</td><td class="field-value">{{ $contract->client->prenom ?? '-' }}</td></tr>
                        <tr><td class="field-label">Date de naissance :</td><td class="field-value">{{ optional($contract->client->date_naissance)->format('d/m/Y') ?? '-' }}</td></tr>
                        <tr><td class="field-label">Lieu de naissance :</td><td class="field-value">{{ $contract->client->lieu_naissance ?? '-' }}</td></tr>
                        <tr><td class="field-label">Adresse :</td><td class="field-value">{{ $contract->client->adresse ?? '-' }}</td></tr>
                        <tr><td class="field-label">N° C.I.N :</td><td class="field-value">{{ $contract->client->cin ?? '-' }}</td></tr>
                        <tr><td class="field-label">Nationalité :</td><td class="field-value">{{ $contract->client->nationalite ?? '-' }}</td></tr>
                        <tr><td class="field-label">N° Permis :</td><td class="field-value">{{ $contract->client->numero_permis ?? '-' }}</td></tr>
                        <tr><td class="field-label">Date permis :</td><td class="field-value">{{ optional($contract->client->date_permis)->format('d/m/Y') ?? '-' }}</td></tr>
                        <tr><td class="field-label">N° Passeport :</td><td class="field-value">{{ $contract->client->passport ?? '-' }}</td></tr>
                        <tr><td class="field-label">Adresse à l'étranger :</td><td class="field-value">{{ $contract->client->adresse_etranger ?? '-' }}</td></tr>
                        <tr><td class="field-label">Téléphone :</td><td class="field-value">{{ $contract->client->telephone ?? '-' }}</td></tr>
                        <tr><td class="field-label">Email :</td><td class="field-value">{{ $contract->client->email ?? '-' }}</td></tr>
                    </table>
                </div>
            </td>

            <!-- VOITURE -->
            <td>
                <div class="box">
                    <div class="box-title">Voiture</div>
                    <table class="field-table">
                        <tr><td class="field-label">Marque :</td><td class="field-value">{{ $contract->vehicle->marque ?? '-' }}</td></tr>
                        <tr><td class="field-label">Immatriculation :</td><td class="field-value">{{ $contract->vehicle->immatriculation ?? '-' }}</td></tr>
                        <tr><td class="field-label">Date de départ :</td><td class="field-value">{{ $contract->date_depart?->format('d/m/Y') ?? '-' }}</td></tr>
                        <tr><td class="field-label">Heure de départ :</td><td class="field-value">{{ $contract->heure_depart ?? '-' }}</td></tr>
                        <tr><td class="field-label">Date de retour :</td><td class="field-value">{{ $contract->date_retour?->format('d/m/Y') ?? '-' }}</td></tr>
                        <tr><td class="field-label">Heure de retour :</td><td class="field-value">{{ $contract->heure_retour ?? '-' }}</td></tr>
                        <tr><td class="field-label">Km départ :</td><td class="field-value">{{ $contract->km_depart ?? '-' }}</td></tr>
                        <tr><td class="field-label">Km retour :</td><td class="field-value">{{ $contract->km_retour ?? '-' }}</td></tr>
                        <tr><td class="field-label">Nombre de jours :</td><td class="field-value">{{ $contract->nombre_jours ?? '-' }}</td></tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr>
            <!-- DEUXIEME CONDUCTEUR -->
            <td>
                <div class="box">
                    <div class="box-title">Deuxieme conducteur</div>
                    @if($contract->secondDriver)
                        <table class="field-table">
                            <tr><td class="field-label">NOM :</td><td class="field-value">{{ $contract->secondDriver->nom ?? '-' }}</td></tr>
                            <tr><td class="field-label">PRENOM :</td><td class="field-value">{{ $contract->secondDriver->prenom ?? '-' }}</td></tr>
                            <tr><td class="field-label">Date de naissance :</td><td class="field-value">{{ optional($contract->secondDriver->date_naissance)->format('d/m/Y') ?? '-' }}</td></tr>
                            <tr><td class="field-label">Lieu de naissance :</td><td class="field-value">{{ $contract->secondDriver->lieu_naissance ?? '-' }}</td></tr>
                            <tr><td class="field-label">Adresse :</td><td class="field-value">{{ $contract->secondDriver->adresse ?? '-' }}</td></tr>
                            <tr><td class="field-label">N° C.I.N :</td><td class="field-value">{{ $contract->secondDriver->cin ?? '-' }}</td></tr>
                            <tr><td class="field-label">Nationalité :</td><td class="field-value">{{ $contract->secondDriver->nationalite ?? '-' }}</td></tr>
                            <tr><td class="field-label">N° Permis :</td><td class="field-value">{{ $contract->secondDriver->numero_permis ?? '-' }}</td></tr>
                            <tr><td class="field-label">Date permis :</td><td class="field-value">{{ optional($contract->secondDriver->date_permis)->format('d/m/Y') ?? '-' }}</td></tr>
                            <tr><td class="field-label">N° Passeport :</td><td class="field-value">{{ $contract->secondDriver->passport ?? '-' }}</td></tr>
                            <tr><td class="field-label">Adresse à l'étranger :</td><td class="field-value">{{ $contract->secondDriver->adresse_etranger ?? '-' }}</td></tr>
                            <tr><td class="field-label">Téléphone :</td><td class="field-value">{{ $contract->secondDriver->telephone ?? '-' }}</td></tr>
                        </table>
                    @else
                        <div class="no-second-driver">Aucun deuxième conducteur</div>
                    @endif
                </div>
            </td>

            <!-- FRAIS -->
            <td>
                <div class="box">
                    <div class="box-title">Frais</div>
                    <table class="field-table">
                        <tr><td class="field-label">Caution :</td><td class="field-value">{{ number_format($contract->caution,2,',',' ') ?? '-' }}</td></tr>
                        <tr><td class="field-label">Avance :</td><td class="field-value">{{ number_format($contract->avance,2,',',' ') ?? '-' }}</td></tr>
                        <tr><td class="field-label">Tarif / jour :</td><td class="field-value">{{ number_format($contract->tarif_jour,2,',',' ') ?? '-' }}</td></tr>
                        <tr><td class="field-label">Total H.T :</td><td class="field-value">{{ number_format($contract->total_ht,2,',',' ') ?? '-' }}</td></tr>
                        <tr><td class="field-label">T.V.A (20%) :</td><td class="field-value">{{ number_format($contract->tva,2,',',' ') ?? '-' }}</td></tr>
                        <tr><td class="field-label">Total T.T.C :</td><td class="field-value">{{ number_format($contract->total_ttc,2,',',' ') ?? '-' }}</td></tr>
                    </table>
                    <br>
                    <table class="field-table">
                        <tr><td class="field-label">Mode De Règlement :</td><td class="field-value">{{ $contract->mode_paiement ?? '-' }}</td></tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <table class="bottom-table">
        <tr>
            <!-- Acceptance + signatures -->
            <td>
                <div class="box" style="padding:0;">
                    <div class="accept-text">
                        Je connais avoir prix connaissance des conditions<br>
                        générales de location au verso du contrat et accepte
                    </div>
                    <div class="signature-row">Signature du locataire :</div>
                    <div class="signature-row">Signature du locataire :</div>
                </div>
            </td>

            <!-- Agent signature + observation -->
            <td>
                <div class="box" style="padding:0;">
                    <div class="signature-row">Signature Agent : {{ $contract->createdBy->name ?? '-' }}</div>
                    <div class="observation-cell">Observation : {{ $contract->observation ?? '-' }}</div>
                </div>
            </td>
        </tr>
    </table>

</div>