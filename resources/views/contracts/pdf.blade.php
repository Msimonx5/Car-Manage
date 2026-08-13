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
    margin-top: 8mm;
    margin-right: 10mm;
    margin-bottom: 8mm;
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
    vertical-align: middle;
  }
  .brand-left {
    width: 55%;
    text-align: center;
  }
  .brand-left img {
    width: 75mm;
  }
  .address {
    font-style: italic;
    font-weight: bold;
    font-size: 9px;
    line-height: 1.4;
    margin-top: 2px;
  }
 .brand-right .company {
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 1px;
    color: #0484f7;
  }
  .brand-right .loc {
    font-size: 14px;
    font-weight: bold;
    color: #0484f7;
  }
  .brand-right .rent {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 13px;
    font-weight: bold;
    color: #0484f7;
  }
  .brand-right .courtes {
    font-family: "Times New Roman", Georgia, serif;
    font-size: 15px;
    color: #0484f7;
  }

  /* ============ TITLE ============ */
  .title {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    font-style: italic;
    margin-top: 4px;
    color: #0484f7;
  }
  .date-line {
    text-align: right;
    font-style: italic;
    font-weight: bold;
    font-size: 12px;
    margin: 5px 4px 7px 0;
    color: #0484f7;
  }

  /* ============ GRID DE BOITES (table = compatible DomPDF) ============ */
  .grid-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 3mm;
    table-layout: fixed;
  }
  .grid-table td {
    width: 50%;
    vertical-align: top;
  }

  .box {
    border: 2px solid #000;
    border-radius: 22px;
    padding: 5px 10px 8px;
  }
  .box-title {
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 5px;
    padding-bottom: 4px;
    border-bottom: 2px solid #000;
    text-transform: uppercase;
  }
  .box-title.long {
    font-size: 13px;
    letter-spacing: 0.5px;
  }

  .field {
    font-size: 11.5px;
    font-weight: bold;
    line-height: 1.2;
    padding: 1px 0;
  }

  .value {
    color: #0484f7;
  }

  .push-bottom {
    padding-top: 10px;
  }

  /* ============ SIGNATURES ============ */
  .sign-left .note {
    font-size: 10px;
    font-weight: bold;
    font-style: italic;
    text-align: center;
    line-height: 1.25;
    padding: 2px 4px 9px;
  }
  .sign-row {
    font-size: 12px;
    font-weight: bold;
    padding: 10px 2px 5px;
    border-top: 1px solid #000;
  }
  .sign-right .sign-big {
    font-size: 13px;
    font-weight: bold;
    padding: 10px 2px;
  }
  .sign-right .sign-big + .sign-big {
    border-top: 1px solid #000;
  }
  .sign-right .obs-text {
    font-size: 9.5px;
    line-height: 1.25;
  }
</style>
</head>

<body>

  <!-- ===================== HEADER ===================== -->
  <table class="header-table">
    <tr>
      <td class="brand-left">
        @php
            $logoSrc = $isPdf
                ? public_path('car_full_logo.jpeg')
                : asset('car_full_logo.jpeg');
        @endphp
        <img src="{{ $logoSrc }}" alt="SOULAMI RENT">
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
  {{-- <div class="date-line">Khouribga Le : {{ $contract->created_at->format('d/m/Y') }}</div> --}}
  <div class="date-line">Khouribga Le : {{ $contract->date_depart->format('d/m/Y') }}</div>

  <!-- ===================== BOXES ===================== -->
<table class="grid-table">
    <tr>
      <!-- ---------- CLIENT ---------- -->
      <td>
        <div class="box">
          <div class="box-title">CLIENT</div>
          <div class="field">NOM : <span class="value">{{ $client->nom }}</span></div>
          <div class="field">PRENOM : <span class="value">{{ $client->prenom }}</span></div>
          <div class="field">
            Date &amp; Lieu de naissance :
            <span class="value">{{ optional($client->date_naissance)->format('d/m/Y') }} - {{ $client->lieu_naissance }}</span>
          </div>
          <div class="field">Adresse : <span class="value">{{ $client->adresse }}</span></div>
          <div class="field">N° C.I.N : <span class="value">{{ $client->cin }}</span></div>
          <div class="field">Nationalité : <span class="value">{{ $client->nationalite }}</span></div>
          <div class="field">N° Permis de conduite : <span class="value">{{ $client->numero_permis }}</span></div>
          <div class="field">N° Passeport : <span class="value">{{ $client->passport }}</span></div>
          <div class="field">Adresse à l'étranger : <span class="value">{{ $client->adresse_etranger }}</span></div>
          <div class="field">Téléphone : <span class="value">{{ $client->telephone }}</span></div>
        </div>
      </td>

      <!-- ---------- VOITURE ---------- -->
      <td>
        <div class="box">
          <div class="box-title">VOITURE</div>
          <div class="field">Marque : <span class="value">{{ $vehicle->marque }} {{ $vehicle->modele }}</span></div>
          <div class="field">Immatriculation : <span class="value">{{ $vehicle->immatriculation }}</span></div>
          <div class="field">Date de départ : <span class="value">{{ $contract->date_depart->format('d/m/Y') }}</span></div>
          <div class="field">Heure de départ : <span class="value">{{ \Carbon\Carbon::parse($contract->heure_depart)->format('H:i') }}</span></div>
          <div class="field">Date de retour : <span class="value">{{ $contract->date_retour->format('d/m/Y') }}</span></div>
          <div class="field">Heure de retour : <span class="value">{{ \Carbon\Carbon::parse($contract->heure_retour)->format('H:i') }}</span></div>
          <div class="field">Km départ : <span class="value">{{ $contract->km_depart }}</span></div>
          <div class="field">Km retour : <span class="value">{{ $contract->km_retour }}</span></div>
          <div class="field">pronologation:</div>
        </div>
      </td>
    </tr>

    <tr>
      <!-- ---------- DEUXIEME CONDUCTEUR ---------- -->
      <td>
        <div class="box">
          <div class="box-title long">DEUXIEME CONDUCTEUR</div>
          <div class="field">NOM : <span class="value">{{ $driver->nom ?? '' }}</span></div>
          <div class="field">PRENOM : <span class="value">{{ $driver->prenom ?? '' }}</span></div>
          <div class="field">
            Date &amp; Lieu de naissance :
            @if($driver)
                <span class="value">{{ optional($driver->date_naissance)->format('d/m/Y') }} - {{ $driver->lieu_naissance }}</span>
            @endif
          </div>
          <div class="field">Adresse : <span class="value">{{ $driver->adresse ?? '' }}</span></div>
          <div class="field">N° C.I.N : <span class="value">{{ $driver->cin ?? '' }}</span></div>
          <div class="field">Nationalité : <span class="value">{{ $driver->nationalite ?? '' }}</span></div>
          <div class="field">N° Permis de conduite : <span class="value">{{ $driver->numero_permis ?? '' }}</span></div>
          <div class="field">N° Passeport : <span class="value">{{ $driver->passport ?? '' }}</span></div>
          <div class="field">Adresse à l'étranger : <span class="value">{{ $driver->adresse_etranger ?? '' }}</span></div>
          <div class="field">Téléphone : <span class="value">{{ $driver->telephone ?? '' }}</span></div>
        </div>
      </td>

      <!-- ---------- FRAIS ---------- -->
      <td>
        <div class="box">
          <div class="box-title">FRAIS</div>
          {{-- <div class="field">Caution : <span class="value">{{ number_format($contract->caution, 2, ',', ' ') }} DH</span></div>
          <div class="field">Avance : <span class="value">{{ number_format($contract->avance, 2, ',', ' ') }} DH</span></div>
          <div class="field">Tarif / jour : <span class="value">{{ number_format($contract->tarif_jour, 2, ',', ' ') }} DH</span></div>
          <div class="field">Nombre de jours : <span class="value">{{ $contract->nombre_jours }}</span></div>
          <div class="field">Total H.T : <span class="value">{{ number_format($contract->total_ht, 2, ',', ' ') }} DH</span></div>
          <div class="field">T.V.A (20%) : <span class="value">{{ number_format($contract->tva, 2, ',', ' ') }} DH</span></div>
          <div class="field">Total T.T.C : <span class="value">{{ number_format($contract->total_ttc, 2, ',', ' ') }} DH</span></div>
          <div class="field push-bottom">Mode De Règlement : <span class="value">{{ $contract->mode_paiement }}</span></div> --}}
          <div class="field">Caution :</span></div>
          <div class="field">Avance :</span></div>
          <div class="field">Tarif / jour :</span></div>
          <div class="field">Nombre de jours :</span></div>
          <div class="field">Total H.T : <span class="value"></span></div>
          <div class="field">T.V.A (20%) : <span class="value"></span></div>
          <div class="field">Total T.T.C : <span class="value"></span></div>
          <div class="field push-bottom">Mode De Règlement : <span class="value"></span></div>
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
          <div class="sign-big obs-text">
            Observation : <span class="value">{{ $contract->observation ?? 'Aucune observation' }}</span>
          </div>
        </div>
      </td>
    </tr>
  </table>

</body>
</html>