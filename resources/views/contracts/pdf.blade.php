@php
    $client = $contract->client;
    $vehicle = $contract->vehicle;
    $driver = $contract->secondDriver;
    $isPdf = $isPdf ?? true; // sécurité si jamais non transmis par le contrôleur
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Contrat de Location - SOULAMI RENT</title>
<style>
  /* ============ PAGE SETUP (obligatoire pour DomPDF) ============ */
  @page {
    size: A4;
    margin-top: 12mm;
    margin-right: 10mm;
    margin-bottom: 12mm;
    margin-left: 10mm;
  }

  /* ============ RESET ============ */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
    color: #000;
    font-size: 11px;
  }

  /* ============ HEADER (table = compatible DomPDF) ============ */
  .header-table {
    width: 100%;
    border-collapse: collapse;
  }
  .header-table td {
    vertical-align: top;
  }
  .brand-left {
    width: 55%;
    text-align: center;
  }
  .brand-left img {
    width: 70mm;
  }
  .address {
    font-style: italic;
    font-weight: bold;
    font-size: 9px;
    line-height: 1.4;
    margin-top: 2px;
  }
  .brand-right {
    width: 45%;
    text-align: center;
    padding-top: 6px;
  }
  .brand-right .company {
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 1px;
  }
  .brand-right .loc {
    font-size: 14px;
    font-weight: bold;
  }
  .brand-right .rent {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 13px;
    font-weight: bold;
  }
  .brand-right .courtes {
    font-family: "Times New Roman", Georgia, serif;
    font-size: 15px;
  }

  /* ============ TITLE ============ */
  .title {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    font-style: italic;
    margin-top: 6px;
  }
  .date-line {
    text-align: right;
    font-style: italic;
    font-weight: bold;
    font-size: 12px;
    margin: 8px 4px 10px 0;
  }

  /* ============ GRID DE BOITES (table = compatible DomPDF) ============ */
  .grid-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 4mm;
    table-layout: fixed;
  }
  .grid-table td {
    width: 50%;
    vertical-align: top;
  }

  .box {
    border: 2px solid #000;
    border-radius: 22px;
    padding: 6px 10px 10px;
  }
  .box-title {
    text-align: center;
    font-size: 17px;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 8px;
    padding-bottom: 6px;
    border-bottom: 2px solid #000;
    text-transform: uppercase;
  }
  .box-title.long {
    font-size: 13px;
    letter-spacing: 0.5px;
  }

  .field {
    font-size: 12px;
    font-weight: bold;
    line-height: 1.35;
    padding: 2px 0;
  }

  .push-bottom {
    padding-top: 14px;
  }

  /* ============ SIGNATURES ============ */
  .sign-left .note {
    font-size: 10px;
    font-weight: bold;
    font-style: italic;
    text-align: center;
    line-height: 1.3;
    padding: 2px 4px 12px;
  }
  .sign-row {
    font-size: 12px;
    font-weight: bold;
    padding: 14px 2px 6px;
    border-top: 1px solid #000;
  }
  .sign-right .sign-big {
    font-size: 13px;
    font-weight: bold;
    padding: 14px 2px;
  }
  .sign-right .sign-big + .sign-big {
    border-top: 1px solid #000;
  }
</style>
</head>

<body>

  <div style="height: 8mm;"></div>

  <!-- ===================== HEADER ===================== -->
  <table class="header-table">
    <tr>
      <td class="brand-left">
        @php
            $logoSrc = $isPdf
                ? public_path('car_logo.jpeg')
                : asset('images/contracts/logo.jpeg');
        @endphp
        <img src="{{ $logoSrc }}" alt="SOULAMI RENT">
        <div class="address">
          N°27, FIRMA OCP KHOURIBGA , Khouribga<br>
          GSM:&nbsp; 06 61 89 55 51 - 08 08 52 29 84
        </div>
      </td>
      <td class="brand-right">
        @php
            $brandRightSrc = $isPdf
                ? public_path('brand-right.jpeg')
                : asset('images/contracts/brand-right.png');
        @endphp
        <img src="{{ $brandRightSrc }}" alt="STÉ SOULAMI CAR" style="width: 65mm;">
      </td>
    </tr>
  </table>

  <!-- ===================== TITLE ===================== -->
  <div class="title">CONTRAT DE LOCATION </div>
  {{-- <div class="title">CONTRAT DE LOCATION N° {{ $contract->numero }}</div> --}}
  <div class="date-line">Khouribga Le : {{ $contract->created_at->format('d/m/Y') }}</div>

  <!-- ===================== BOXES ===================== -->
  <table class="grid-table">
    <tr>
      <!-- ---------- CLIENT ---------- -->
      <td>
        <div class="box">
          <div class="box-title">CLIENT</div>
          <div class="field">NOM : {{ $client->nom }}</div>
          <div class="field">PRENOM : {{ $client->prenom }}</div>
          <div class="field">
            Date &amp; Lieu de naissance :
            {{ optional($client->date_naissance)->format('d/m/Y') }} - {{ $client->lieu_naissance }}
          </div>
          <div class="field">Adresse : {{ $client->adresse }}</div>
          <div class="field">N° C.I.N : {{ $client->cin }}</div>
          <div class="field">Nationalité : {{ $client->nationalite }}</div>
          <div class="field">N° Permis de conduite : {{ $client->numero_permis }}</div>
          <div class="field">N° Passeport : {{ $client->passport }}</div>
          <div class="field">Adresse à l'étranger : {{ $client->adresse_etranger }}</div>
          <div class="field">Téléphone : {{ $client->telephone }}</div>
        </div>
      </td>

      <!-- ---------- VOITURE ---------- -->
      <td>
        <div class="box">
          <div class="box-title">VOITURE</div>
          <div class="field">Marque : {{ $vehicle->marque }} {{ $vehicle->modele }}</div>
          <div class="field">Immatriculation : {{ $vehicle->immatriculation }}</div>
          <div class="field">Date de départ : {{ $contract->date_depart->format('d/m/Y') }}</div>
          <div class="field">Heure de départ : {{ \Carbon\Carbon::parse($contract->heure_depart)->format('H:i') }}</div>
          <div class="field">Date de retour : {{ $contract->date_retour->format('d/m/Y') }}</div>
          <div class="field">Heure de retour : {{ \Carbon\Carbon::parse($contract->heure_retour)->format('H:i') }}</div>
          <div class="field">Km départ : {{ $contract->km_depart }}</div>
          <div class="field">Km retour : {{ $contract->km_retour }}</div>
        </div>
      </td>
    </tr>

    <tr>
      <!-- ---------- DEUXIEME CONDUCTEUR ---------- -->
      <td>
        <div class="box">
          <div class="box-title long">DEUXIEME CONDUCTEUR</div>
          @if($driver)
            <div class="field">NOM : {{ $driver->nom }}</div>
            <div class="field">PRENOM : {{ $driver->prenom }}</div>
            <div class="field">
              Date &amp; Lieu de naissance :
              {{ optional($driver->date_naissance)->format('d/m/Y') }} - {{ $driver->lieu_naissance }}
            </div>
            <div class="field">Adresse : {{ $driver->adresse }}</div>
            <div class="field">N° C.I.N : {{ $driver->cin }}</div>
            <div class="field">Nationalité : {{ $driver->nationalite }}</div>
            <div class="field">N° Permis de conduite : {{ $driver->numero_permis }}</div>
            <div class="field">N° Passeport : {{ $driver->passport }}</div>
            <div class="field">Adresse à l'étranger : {{ $driver->adresse_etranger }}</div>
            <div class="field">Téléphone : {{ $driver->telephone }}</div>
          @else
            <div class="field">Aucun deuxième conducteur</div>
          @endif
        </div>
      </td>

      <!-- ---------- FRAIS ---------- -->
      <td>
        <div class="box">
          <div class="box-title">FRAIS</div>
          <div class="field">Caution : {{ number_format($contract->caution, 2, ',', ' ') }} DH</div>
          <div class="field">Avance : {{ number_format($contract->avance, 2, ',', ' ') }} DH</div>
          <div class="field">Tarif / jour : {{ number_format($contract->tarif_jour, 2, ',', ' ') }} DH</div>
          <div class="field">Nombre de jours : {{ $contract->nombre_jours }}</div>
          <div class="field">Total H.T : {{ number_format($contract->total_ht, 2, ',', ' ') }} DH</div>
          <div class="field">T.V.A (20%) : {{ number_format($contract->tva, 2, ',', ' ') }} DH</div>
          <div class="field">Total T.T.C : {{ number_format($contract->total_ttc, 2, ',', ' ') }} DH</div>
          <div class="field push-bottom">Mode De Règlement : {{ $contract->mode_paiement }}</div>
        </div>
      </td>
    </tr>

    <tr>
      <!-- ---------- SIGNATURE LOCATAIRE ---------- -->
      <td>
        <div class="box sign-left">
          <div class="note">
            Je connais avoir prix connaissance des conditions
            générales de location au verso du contrat et accepte
          </div>
          <div class="sign-row">Signature du locataire :</div>
          <div class="sign-row">Signature du locataire :</div>
        </div>
      </td>

      <!-- ---------- SIGNATURE AGENT ---------- -->
      <td>
        <div class="box sign-right">
          <div class="sign-big">Signature Agent :</div>
          <div class="sign-big">
            Observation : {{ $contract->observation ?? 'Aucune observation' }}
          </div>
        </div>
      </td>
    </tr>
  </table>

</body>
</html>