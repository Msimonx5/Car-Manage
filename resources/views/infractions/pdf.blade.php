{{-- resources/views/infractions/pdf.blade.php --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Préparation des données
    |--------------------------------------------------------------------------
    */

    $cp = str_split(
        str_pad(
            (string) ($infraction->code_postal ?? ''),
            5,
            '0',
            STR_PAD_LEFT
        )
    );
@endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <title>
        Déclaration préalable de location de voiture - SOULAMI CAR
    </title>

    <style>
        /*
        |--------------------------------------------------------------------------
        | PAGE A4
        |--------------------------------------------------------------------------
        */

        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #ffffff;
            color: #000000;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            line-height: 1.3;
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENEUR PRINCIPAL
        |--------------------------------------------------------------------------
        */

        .main-wrapper {
            width: 100%;
            margin: 0 auto;
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .header-banner {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;

            background-color: #eeeeee;

            padding: 8px 12px;
            margin-bottom: 8px;

            min-height: 75px;
        }

        .header-left {
            width: 40%;
            text-align: center;
            font-size: 12px;
            line-height: 1.35;
        }

        .header-left strong {
            display: block;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .header-center {
            width: 20%;
            text-align: center;
        }

        .header-center img {
            display: block;
            width: auto;
            max-width: 75px;
            max-height: 65px;
            margin: 0 auto;
        }

        .header-right {
            width: 40%;

            direction: rtl;
            text-align: center;

            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        .header-right strong {
            display: block;
            font-size: 16px;
            margin-bottom: 3px;
        }

        /*
        |--------------------------------------------------------------------------
        | TITRE
        |--------------------------------------------------------------------------
        */

        .title-container {
            position: relative;

            width: 100%;

            text-align: center;

            padding: 8px 0 10px;
            margin-bottom: 8px;
        }

        .ref-box {
            position: absolute;

            left: 0;
            top: 5px;

            border: 1px solid #999999;

            padding: 4px 10px;

            font-size: 13px;
            font-weight: bold;
        }

        .main-titles h1 {
            margin: 3px 0;
            font-size: 19px;
            line-height: 1.3;

            direction: rtl;
            font-family: Arial, sans-serif;
        }

        .main-titles h2 {
            margin: 3px 0;
            font-size: 17px;
            line-height: 1.3;
        }

        .subtitle-ar {
            margin: 2px 0;

            direction: rtl;
            text-align: center;

            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .subtitle-fr {
            margin: 2px 0;

            font-size: 11px;
            font-style: italic;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE PRINCIPALE
        |--------------------------------------------------------------------------
        */

        .document-container {
            width: 100%;

            border: 1.5px solid #000000;
            border-collapse: collapse;

            table-layout: fixed;

            page-break-inside: auto;
        }

        .document-container tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .document-container td {
            border: 1px solid #000000;

            padding: 5px 8px;

            vertical-align: middle;

            font-size: 12px;

            line-height: 1.3;
        }

        /*
        |--------------------------------------------------------------------------
        | VALEURS
        |--------------------------------------------------------------------------
        */

        .value {
            color: #1a3c61;

            font-weight: bold;

            font-size: 13px;

            text-transform: uppercase;
        }

        /*
        |--------------------------------------------------------------------------
        | ARABE
        |--------------------------------------------------------------------------
        */

        .arabic {
            direction: rtl;
            text-align: right;

            font-family: Arial, sans-serif;

            font-size: 12px;

            line-height: 1.5;

            unicode-bidi: plaintext;
        }

        /*
        |--------------------------------------------------------------------------
        | FLEX ROW
        |--------------------------------------------------------------------------
        */

        .flex-row {
            display: flex;

            width: 100%;

            align-items: center;
            justify-content: space-between;

            gap: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | ALIGNEMENT
        |--------------------------------------------------------------------------
        */

        .text-center {
            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | BORDURES
        |--------------------------------------------------------------------------
        */

        .no-side-borders {
            border-left: none !important;
            border-right: none !important;
        }

        /*
        |--------------------------------------------------------------------------
        | CODE POSTAL
        |--------------------------------------------------------------------------
        */

        .postal-container {
            display: inline-flex;

            height: 21px;

            border: 1px solid #000000;
            border-right: none;

            vertical-align: middle;
        }

        .postal-box {
            width: 21px;
            height: 20px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-right: 1px solid #000000;

            color: #1a3c61;

            font-size: 12px;
            font-weight: bold;
        }

        /*
        |--------------------------------------------------------------------------
        | IMMATRICULATION
        |--------------------------------------------------------------------------
        */

        .plate-border {
            display: inline-block;

            border: 3px solid #000000;

            padding: 3px 15px;

            margin-bottom: 3px;

            color: #1a3c61;

            font-size: 16px;
            font-weight: bold;

            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | AGENCE
        |--------------------------------------------------------------------------
        */

        .company-name {
            display: block;

            color: #1a3c61;

            font-size: 13px;
            font-weight: bold;

            text-decoration: none;
            text-transform: uppercase;
        }

        /*
        |--------------------------------------------------------------------------
        | LIGNES
        |--------------------------------------------------------------------------
        */

        .line-row {
            display: flex;

            width: 100%;

            align-items: center;
            justify-content: space-between;

            margin-bottom: 5px;
        }

        .line-segment {
            width: 49%;
            height: 1px;

            background-color: #000000;
        }

        .center-gap {
            width: 2%;
        }

        /*
        |--------------------------------------------------------------------------
        | SECTION VEHICULE
        |--------------------------------------------------------------------------
        */

        .vehicle-section {
            padding: 10px 8px !important;
            border-bottom: none !important;
        }

        /*
        |--------------------------------------------------------------------------
        | DATES
        |--------------------------------------------------------------------------
        */

        .date-row {
            min-height: 30px;
        }

        /*
        |--------------------------------------------------------------------------
        | SIGNATURES
        |--------------------------------------------------------------------------
        */

        .signature-row {
            page-break-inside: avoid;
        }

        .signature-row td {
            height: 150px;

            padding: 10px;

            vertical-align: top !important;
        }

        .sig-box-left {
            width: 55%;

            text-align: center;

            vertical-align: top !important;
        }

        .sig-box-right {
            width: 45%;

            border-left: 1.5px solid #000000 !important;

            vertical-align: top !important;
        }

        /*
        |--------------------------------------------------------------------------
        | IMPRESSION
        |--------------------------------------------------------------------------
        */

        @media print {
            body {
                background: #ffffff;
            }

            .main-wrapper {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="main-wrapper">

    {{-- ================================================================== --}}
    {{-- HEADER --}}
    {{-- ================================================================== --}}

    <header class="header-banner">

        <div class="header-left">
            <strong>ROYAUME DU MAROC</strong>
            Ministère de l’Equipement, du Transport et de la Logistique
        </div>

        <div class="header-center">

            <img
                src="{{ public_path('images/logo_maroc.jpeg') }}"
                alt="Royaume du Maroc Logo"
            >

        </div>

        <div class="header-right">
            <strong>المملكة المغربية</strong>
            وزارة التجهيز والنقل واللوجيستيك
        </div>

    </header>


    {{-- ================================================================== --}}
    {{-- TITRE --}}
    {{-- ================================================================== --}}

    <div class="title-container">

        <div class="ref-box">
            Réf. : DPL1
        </div>

        <div class="main-titles">

            <h1>
                التصريح القبلي بكراء سيارة بدون سائق
            </h1>

            <p class="subtitle-ar">
                (يعبأ من طرف المكتري القاطن بالمغرب)
            </p>

            <h2>
                Déclaration préalable de location de voiture sans chauffeur
            </h2>

            <p class="subtitle-fr">
                (à renseigner par le locataire résidant au Maroc)
            </p>

        </div>

    </div>


    {{-- ================================================================== --}}
    {{-- TABLEAU PRINCIPAL --}}
    {{-- ================================================================== --}}

    <table class="document-container">

        {{-- ================================================================ --}}
        {{-- IDENTITE --}}
        {{-- ================================================================ --}}

        <tr>

            <td colspan="3">
                Je soussigné(e) :
            </td>

            <td colspan="3" class="arabic">
                أنا الممضي (ة) أسفله
            </td>

        </tr>


        {{-- NOM --}}
        <tr>

            <td colspan="6" class="no-side-borders">

                <div class="flex-row">

                    <div style="width: 15%;">
                        Nom
                    </div>

                    <div
                        class="value"
                        style="flex-grow: 1; text-align: left;"
                    >
                        {{ $infraction->nom }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 20%;"
                    >
                        الاسم العائلي
                    </div>

                </div>

            </td>

        </tr>


        {{-- PRENOM --}}
        <tr>

            <td colspan="6" class="no-side-borders">

                <div class="flex-row">

                    <div style="width: 15%;">
                        Prénom (s)
                    </div>

                    <div
                        class="value"
                        style="flex-grow: 1; text-align: left;"
                    >
                        {{ $infraction->prenom }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 20%;"
                    >
                        الاسم الشخصي
                    </div>

                </div>

            </td>

        </tr>


        {{-- CIN --}}
        <tr>

            <td colspan="2" style="width: 30%;">
                N° de la C.N.I.E<br>
                Ou carte de séjour
            </td>

            <td colspan="2" class="text-center" style="width: 40%;">

                <span class="value">
                    {{ $infraction->cin }}
                </span>

            </td>

            <td colspan="2" class="arabic" style="width: 30%;">

                رقم البطاقة الوطنية للتعريف الإلكترونية أو بطاقة الإقامة

            </td>

        </tr>


        {{-- PERMIS --}}
        <tr>

            <td colspan="2">
                N° du permis de conduire
            </td>

            <td colspan="2" class="text-center">

                <span class="value">
                    {{ $infraction->numero_permis }}
                </span>

            </td>

            <td colspan="2" class="arabic">

                رقم رخصة السياقة

            </td>

        </tr>


        {{-- ADRESSE --}}
        <tr>

            <td colspan="6" class="no-side-borders">

                <div class="flex-row">

                    <div style="width: 10%;">
                        Adresse
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: center;
                            text-transform: none;
                        "
                    >
                        {{ $infraction->adresse }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 10%;"
                    >
                        العنوان
                    </div>

                </div>

            </td>

        </tr>


        {{-- VILLE --}}
        <tr>

            <td colspan="6" class="no-side-borders">

                <div class="flex-row">

                    <div style="width: 10%;">
                        Ville
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: left;
                        "
                    >
                        {{ $infraction->ville }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 10%;"
                    >
                        المدينة
                    </div>

                </div>

            </td>

        </tr>


        {{-- CODE POSTAL --}}
        <tr>

            <td colspan="6" class="no-side-borders">

                <div class="flex-row">

                    <span>
                        Code postal
                    </span>

                    <div class="postal-container">

                        @foreach ($cp as $digit)

                            <div class="postal-box">
                                {{ $digit }}
                            </div>

                        @endforeach

                    </div>

                    <span class="arabic">
                        الرمز البريدي
                    </span>

                </div>

            </td>

        </tr>


        {{-- TELEPHONE --}}
        <tr>

            <td colspan="6" class="no-side-borders">

                <div class="flex-row">

                    <div style="width: 10%;">
                        N° de GSM
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: left;
                        "
                    >
                        {{ $infraction->telephone }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 10%;"
                    >
                        الهاتف النقال
                    </div>

                </div>

            </td>

        </tr>


        {{-- EMAIL --}}
        <tr>

            <td colspan="6" class="no-side-borders">

                <div class="flex-row">

                    <span>
                        Adresse mail
                    </span>

                    <span
                        class="value"
                        style="text-transform: none;"
                    >
                        {{ $infraction->email }}
                    </span>

                    <span class="arabic">
                        العنوان الإلكتروني
                    </span>

                </div>

            </td>

        </tr>


        {{-- ================================================================ --}}
        {{-- VEHICULE --}}
        {{-- ================================================================ --}}

        <tr>

            <td
                colspan="6"
                class="vehicle-section"
            >

                <div
                    class="flex-row"
                    style="align-items: flex-start;"
                >

                    {{-- Français --}}
                    <div
                        style="
                            width: 38%;
                            line-height: 1.5;
                        "
                    >

                        Déclare avoir pris en location le véhicule<br>

                        Immatriculé sous numéro :<br>

                        et appartenant à l’agence de location

                    </div>


                    {{-- IMMATRICULATION --}}
                    <div
                        class="text-center"
                        style="width: 24%;"
                    >

                        <div class="plate-border">
                            {{ $infraction->immatriculation }}
                        </div>

                        <span class="company-name">
                            SOULAMI CAR
                        </span>

                    </div>


                    {{-- Arabe --}}
                    <div
                        class="arabic"
                        style="
                            width: 38%;
                            line-height: 1.5;
                        "
                    >

                        أصرح أنني اكتريت المركبة المسجلة<br>

                        تحت رقم :<br>

                        والتي هي في ملكية وكالة كراء السيارات :

                    </div>

                </div>

            </td>

        </tr>


        {{-- MARQUE / MODELE --}}
        <tr>

            <td
                colspan="6"
                style="
                    padding: 8px 12px;
                    border-top: none;
                "
            >

                <div class="line-row">

                    <div class="line-segment"></div>

                    <div class="center-gap"></div>

                    <div class="line-segment"></div>

                </div>

                <div
                    class="text-center value"
                    style="
                        margin-top: -5px;
                        text-transform: uppercase;
                    "
                >
                    {{ $infraction->marque }}
                    {{ $infraction->modele }}
                </div>

            </td>

        </tr>


        {{-- ================================================================ --}}
        {{-- PERIODE --}}
        {{-- ================================================================ --}}

        <tr>

            <td
                colspan="6"
                class="no-side-borders"
            >

                <div class="flex-row">

                    <span>
                        Pour la période allant du :
                    </span>

                    <span class="arabic">
                        للفترة المتراوحة من :
                    </span>

                </div>

            </td>

        </tr>


        {{-- DATE DEPART --}}
        <tr>

            <td
                colspan="6"
                class="no-side-borders"
            >

                <div class="flex-row date-row">

                    <div style="width: 35%;">
                        Jour d’emprunt (JJ/MM/AAAA) :
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: center;
                        "
                    >
                        {{ $infraction->date_depart?->format('d/m/Y') }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 35%;"
                    >
                        يوم تسلم المركبة :
                    </div>

                </div>

            </td>

        </tr>


        {{-- HEURE DEPART --}}
        <tr>

            <td
                colspan="6"
                class="no-side-borders"
            >

                <div class="flex-row date-row">

                    <div style="width: 35%;">
                        Heure d’emprunt (HH :MM)
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: center;
                        "
                    >
                        {{ $infraction->heure_depart }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 35%;"
                    >
                        ساعة تسلم المركبة :
                    </div>

                </div>

            </td>

        </tr>


        {{-- AU --}}
        <tr>

            <td
                colspan="6"
                class="no-side-borders"
            >

                <div class="flex-row date-row">

                    <div style="width: 35%;">
                        Au :
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: center;
                        "
                    >
                        {{ $infraction->date_retour?->format('d/m/Y') }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 35%;"
                    >
                        إلى :
                    </div>

                </div>

            </td>

        </tr>


        {{-- DATE RETOUR --}}
        <tr>

            <td
                colspan="6"
                class="no-side-borders"
            >

                <div class="flex-row date-row">

                    <div style="width: 35%;">
                        Jour de restitution (JJ/MM/AAAA) :
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: center;
                        "
                    >
                        {{ $infraction->date_retour?->format('d/m/Y') }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 35%;"
                    >
                        يوم إعادة المركبة :
                    </div>

                </div>

            </td>

        </tr>


        {{-- HEURE RETOUR --}}
        <tr>

            <td
                colspan="6"
                class="no-side-borders"
            >

                <div class="flex-row date-row">

                    <div style="width: 35%;">
                        Heure de restitution (HH :MM)
                    </div>

                    <div
                        class="value"
                        style="
                            flex-grow: 1;
                            text-align: center;
                        "
                    >
                        {{ $infraction->heure_retour }}
                    </div>

                    <div
                        class="arabic"
                        style="width: 35%;"
                    >
                        ساعة إعادة المركبة :
                    </div>

                </div>

            </td>

        </tr>


        {{-- ================================================================ --}}
        {{-- FOOTER --}}
        {{-- ================================================================ --}}

        <tr>

            <td colspan="6">

                <div class="flex-row">

                    <span>
                        Fait à :

                        <span class="value">
                            {{ $infraction->ville }}
                        </span>
                    </span>

                    <span class="arabic">
                        حرر ب :
                    </span>

                </div>

            </td>

        </tr>


        <tr>

            <td colspan="6">

                <div class="flex-row">

                    <span>
                        Le :

                        <span class="value">
                            {{ $infraction->date_depart?->format('d/m/Y') }}
                        </span>
                    </span>

                    <span class="arabic">
                        في :
                    </span>

                </div>

            </td>

        </tr>


        {{-- ================================================================ --}}
        {{-- SIGNATURES --}}
        {{-- ================================================================ --}}

        <tr class="signature-row">

            <td
                colspan="3"
                class="sig-box-left"
            >

                <div
                    class="arabic"
                    style="
                        text-align: center;
                        margin-bottom: 5px;
                        width: 100%;
                    "
                >
                    الإمضاء وخاتم وكالة كراء السيارات
                </div>

                <div>
                    Signature et cachet de l’agence de location
                </div>

            </td>


            <td
                colspan="3"
                class="sig-box-right"
            >

                <div
                    class="flex-row"
                    style="align-items: flex-start;"
                >

                    <span>
                        Signature du locataire
                    </span>

                    <span class="arabic">
                        إمضاء المكتري
                    </span>

                </div>

            </td>

        </tr>

    </table>

</div>

</body>
</html>
