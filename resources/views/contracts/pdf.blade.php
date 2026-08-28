@php
    $client = $contract->client;
    $vehicle = $contract->vehicle;
    $driver = $contract->secondDriver;
    $isPdf = $isPdf ?? true; // sécurité si jamais non transmis par le contrôleur

    // ===== Remplissage automatique des champs vides par des étoiles =====
    $star = '**************';
    $val = function ($v) use ($star) {
        if ($v === null) return $star;
        $v = trim((string) $v);
        return $v === '' ? $star : $v;
    };
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
    max-height: 20mm;
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
  /* Budget de la page A4 (zone utile 281mm après marges 8mm haut/bas) :
     header ~28mm + titre ~10mm + date ~10mm = ~48mm déjà utilisés.
     Reste ~233mm. On réserve 215mm aux 3 lignes de boîtes (+ 12mm de
     border-spacing), avec une marge de sécurité de ~6mm pour ne jamais
     dépasser une page. On fixe donc une hauteur RÉELLE (pas 1px, pas de
     height sur <tr>) directement sur chaque <td> d'une même ligne :
     c'est la seule façon fiable de contrôler la hauteur avec DomPDF. */
  .grid-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 3mm;
    table-layout: fixed;
    page-break-inside: avoid;
  }
  .grid-table td {
    width: 50%;
    vertical-align: top;
  }
  /* La bordure/le cadre arrondi est posé DIRECTEMENT sur le <td> (et non
     sur un <div> interne en height:100%, qui provoquait le bug — DomPDF
     résolvait ce pourcentage contre la hauteur de la PAGE entière au lieu
     de celle de la cellule, faisant exploser chaque ligne sur sa propre
     page). Les <td> d'une même ligne s'égalisent nativement en hauteur
     dans un tableau : CLIENT/VOITURE (et DEUXIEME CONDUCTEUR/FRAIS)
     obtiennent donc la même hauteur de façon fiable avec DomPDF. */
  .boxed {
    border: 2px solid #000;
    border-radius: 22px;
    padding: 6px 10px 8px;
  }
  .cell-row1,
  .cell-row2 {
    height: 74mm;
  }
  .cell-row3 {
    height: 50mm;
  }

  .box {
  }
  .box-title {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 5px;
    padding-bottom: 4px;
    border-bottom: 2px solid #000;
    text-transform: uppercase;
  }
  .box-title.long {
    font-size: 12px;
    letter-spacing: 0.5px;
  }

  /* Espacement compact mais lisible, calculé pour que les 10 champs de
     CLIENT / DEUXIEME CONDUCTEUR tiennent dans les 80mm réservés. */
  .field {
    font-size: 10.5px;
    font-weight: bold;
    line-height: 1.2;
    padding: 3px 0;
  }
  /* Boîtes avec moins de champs (VOITURE, FRAIS) : espacement plus large
     pour occuper une hauteur comparable, sans dépasser les 80mm réservés. */
  .box-sparse .field {
    padding: 7px 0;
  }

  .value {
    color: #0484f7;
  }

  .push-bottom {
    padding-top: 10px;
  }

  /* ============ SIGNATURES ============ */
  .sign-left .note {
    font-size: 9px;
    font-weight: bold;
    font-style: italic;
    text-align: center;
    line-height: 1.2;
    padding: 2px 4px 5px;
  }
  .sign-row {
    font-size: 11px;
    font-weight: bold;
    padding: 5px 2px 3px;
    border-top: 1px solid #000;
  }
  .sign-space {
    height: 11mm; /* espace vide réservé à la signature manuscrite */
    width: 100%;
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
        <img src="{{ $brandRightSrc }}" alt="STÉ SOULAMI CAR" style="width: 65mm; max-height: 20mm;">
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
      <td class="cell-row1 boxed">
        <div class="box">
          <div class="box-title">CLIENT</div>
          <div class="field">NOM : <span class="value">{{ $val($client->nom) }}</span></div>
          <div class="field">PRENOM : <span class="value">{{ $val($client->prenom) }}</span></div>
          <div class="field">
            Date &amp; Lieu de naissance :
            <span class="value">{{ $val(optional($client->date_naissance)->format('d/m/Y')) }} - {{ $val($client->lieu_naissance) }}</span>
          </div>
          <div class="field">Adresse : <span class="value">{{ $val($client->adresse) }}</span></div>
          <div class="field">N° C.I.N : <span class="value">{{ $val($client->cin) }}</span></div>
          <div class="field">Nationalité : <span class="value">{{ $val($client->nationalite) }}</span></div>
          <div class="field">N° Permis de conduite : <span class="value">{{ $val($client->numero_permis) }}</span></div>
          <div class="field">N° Passeport : <span class="value">{{ $val($client->passport) }}</span></div>
          <div class="field">Adresse à l'étranger : <span class="value">{{ $val($client->adresse_etranger) }}</span></div>
          <div class="field">Téléphone : <span class="value">{{ $val($client->telephone) }}</span></div>
        </div>
      </td>

      <!-- ---------- VOITURE ---------- -->
      <td class="cell-row1 boxed">
        <div class="box box-sparse">
          <div class="box-title">VOITURE</div>
          <div class="field">Marque : <span class="value">{{ $val(trim(($vehicle->marque ?? '').' '.($vehicle->modele ?? ''))) }}</span></div>
          <div class="field">Immatriculation : <span class="value">{{ $val($vehicle->immatriculation) }}</span></div>
          <div class="field">Date de départ : <span class="value">{{ $val($contract->date_depart->format('d/m/Y')) }}</span></div>
          <div class="field">Heure de départ : <span class="value">{{ $val(\Carbon\Carbon::parse($contract->heure_depart)->format('H:i')) }}</span></div>
          <div class="field">Date de retour : <span class="value">{{ $val($contract->date_retour->format('d/m/Y')) }}</span></div>
          <div class="field">Heure de retour : <span class="value">{{ $val(\Carbon\Carbon::parse($contract->heure_retour)->format('H:i')) }}</span></div>
          <div class="field">Km départ : <span class="value">{{ $val($contract->km_depart) }}</span></div>
          <div class="field">Km retour : <span class="value">{{ $val($contract->km_retour) }}</span></div>
          <div class="field">pronologation : <span class="value">{{ $val($contract->prorogation ?? null) }}</span></div>
        </div>
      </td>
    </tr>

    <tr>
      <!-- ---------- DEUXIEME CONDUCTEUR ---------- -->
      <td class="cell-row2 boxed">
        <div class="box">
          <div class="box-title long">DEUXIEME CONDUCTEUR</div>
          <div class="field">NOM : <span class="value">{{ $val($driver->nom ?? null) }}</span></div>
          <div class="field">PRENOM : <span class="value">{{ $val($driver->prenom ?? null) }}</span></div>
          <div class="field">
            Date &amp; Lieu de naissance :
            <span class="value">{{ $val($driver ? optional($driver->date_naissance)->format('d/m/Y') : null) }} - {{ $val($driver->lieu_naissance ?? null) }}</span>
          </div>
          <div class="field">Adresse : <span class="value">{{ $val($driver->adresse ?? null) }}</span></div>
          <div class="field">N° C.I.N : <span class="value">{{ $val($driver->cin ?? null) }}</span></div>
          <div class="field">Nationalité : <span class="value">{{ $val($driver->nationalite ?? null) }}</span></div>
          <div class="field">N° Permis de conduite : <span class="value">{{ $val($driver->numero_permis ?? null) }}</span></div>
          <div class="field">N° Passeport : <span class="value">{{ $val($driver->passport ?? null) }}</span></div>
          <div class="field">Adresse à l'étranger : <span class="value">{{ $val($driver->adresse_etranger ?? null) }}</span></div>
          <div class="field">Téléphone : <span class="value">{{ $val($driver->telephone ?? null) }}</span></div>
        </div>
      </td>

      <!-- ---------- FRAIS ---------- -->
      <td class="cell-row2 boxed">
        <div class="box box-sparse">
          <div class="box-title">FRAIS</div>
          {{-- <div class="field">Caution : <span class="value">{{ number_format($contract->caution, 2, ',', ' ') }} DH</span></div>
          <div class="field">Avance : <span class="value">{{ number_format($contract->avance, 2, ',', ' ') }} DH</span></div>
          <div class="field">Tarif / jour : <span class="value">{{ number_format($contract->tarif_jour, 2, ',', ' ') }} DH</span></div>
          <div class="field">Nombre de jours : <span class="value">{{ $contract->nombre_jours }}</span></div>
          <div class="field">Total H.T : <span class="value">{{ number_format($contract->total_ht, 2, ',', ' ') }} DH</span></div>
          <div class="field">T.V.A (20%) : <span class="value">{{ number_format($contract->tva, 2, ',', ' ') }} DH</span></div>
          <div class="field">Total T.T.C : <span class="value">{{ number_format($contract->total_ttc, 2, ',', ' ') }} DH</span></div>
          <div class="field push-bottom">Mode De Règlement : <span class="value">{{ $contract->mode_paiement }}</span></div> --}}
          <div class="field">Caution :<span class="value">**************</span></div>
          <div class="field">Avance :<span class="value">**************</span></div>
          <div class="field">Tarif / jour :<span class="value">**************</span></div>
          <div class="field">Nombre de jours :<span class="value">**************</span></div>
          <div class="field">Total H.T : <span class="value">**************</span></div>
          <div class="field">T.V.A (20%) : <span class="value">**************</span></div>
          <div class="field">Total T.T.C : <span class="value">**************</span></div>
          <div class="field push-bottom">Mode De Règlement : <span class="value">**************</span></div>
        </div>
      </td>
    </tr>

    <tr>
      <!-- ---------- SIGNATURE LOCATAIRE ---------- -->
      <td class="cell-row3 boxed">
        <div class="box sign-left">
          <div class="note">
            Je connais avoir prix connaissance des conditions
            générales de location au verso du contrat et accepte
          </div>
          <div class="sign-row">Signature du locataire :</div>
          <div class="sign-space"></div>
          <div class="sign-row">Signature du locataire :</div>
          <div class="sign-space"></div>
        </div>
      </td>

      <!-- ---------- SIGNATURE AGENT ---------- -->
      <td class="cell-row3 boxed">
        <div class="box sign-right">
          <div class="sign-big">Signature Agent :</div>
          <div class="sign-space"></div>
          <div class="sign-big obs-text">
            Observation : <span class="value">{{ $contract->observation ?? 'Aucune observation' }}</span>
          </div>
        </div>
      </td>
    </tr>
  </table>
@include('contracts.partials.conditions')
</body>
</html>