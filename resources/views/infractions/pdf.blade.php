@php
    $client = $infraction->client;
    $vehicle = $infraction->vehicle;
    $contract = $infraction->contract;
    $logoPath = public_path('narsa.jpeg');
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déclaration préalable de location - Contrat {{ $contract?->numero }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
            -webkit-print-color-adjust: exact;
        }

        .main-wrapper {
            width: 100%;
            max-width: 190mm;
            margin: auto;
        }

        /* --- HEADER --- */
        .header-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #eeeeee !important;
            padding: 8px 15px;
            text-align: center;
            border: 1px solid #000;
            border-bottom: none;
        }

        .header-left, .header-right { width: 40%; font-size: 11px; line-height: 1.2; }
        .header-left strong { font-size: 13px; }
        .header-center { width: 20%; }
        .header-center img { max-height: 55px; }
        .header-right { direction: rtl; font-family: Arial, sans-serif; }
        .header-right strong { font-size: 14px; }

        /* --- TITLES --- */
        .title-container {
            position: relative;
            text-align: center;
            padding: 10px 0;
            border: 1px solid #000;
            border-top: none;
        }
        .ref-box { position: absolute; left: 10px; top: 10px; border: 1px solid #000; padding: 3px 10px; font-weight: bold; font-size: 12px; }
        .main-titles h1 { font-size: 18px; margin: 2px 0; font-family: Arial, sans-serif; }
        .main-titles h2 { font-size: 16px; margin: 2px 0; font-weight: bold; }
        .subtitle-ar { direction: rtl; font-size: 12px; margin: 0; font-weight: bold; font-family: Arial, sans-serif; }
        .subtitle-fr { font-style: italic; font-size: 12px; margin: 0; }

        /* --- TABLE --- */
        .document-container {
            width: 100%;
            border: 1.2px solid #000;
            border-collapse: collapse;
        }
        .document-container td {
            border: 0.8px solid #000;
            padding: 5px 10px;
            vertical-align: middle;
            font-size: 12px;
            color: #000;
        }
        .value {
            font-family: "Times New Roman", Times, serif !important;
            color: #1a3c72;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .arabic {
            direction: rtl;
            text-align: right;
            font-family: Arial, sans-serif;
            font-size: 12.5px;
            white-space: nowrap;
            color: #000;
        }
        .flex-row { display: flex; justify-content: space-between; align-items: center; width: 100%; }

        /* --- SPECIFIC ELEMENTS --- */
    .postal-container {
        display: inline-flex;
        border: 1px solid #000;
        border-top: none;
        border-right: none;
        height: 18px;
    }        
    .postal-box {
        font-family: "Times New Roman", Times, serif !important;
        width: 18px;
        border-right: 1px solid #000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #1a3c72;
        font-size: 11px;
    }

    .plate-border {
        font-family: "Times New Roman", Times, serif !important;
        border: 2.5px solid #000;
        display: inline-block;
        padding: 3px 15px;
        font-weight: bold;
        font-size: 16px;
        color: #1a3c72;
        margin-bottom: 3px;
    }

    .company-name {
        font-family: "Times New Roman", Times, serif !important;
        display: block;
        color: #1a3c72;
        font-weight: bold;
        font-size: 12px;
    }
        .line-segment { height: 1px; border-bottom: 0.5px solid #666; width: 48%; margin: 5px 0; }

        /* --- SIGNATURES --- */
        .signature-row td { height: 160px; vertical-align: top !important; padding: 10px; }
        .sig-box-left { width: 65%; text-align: center; border-right: 1.2px solid #000; }
        .sig-box-right { width: 35%; }

        .no-side-borders { border-left: none; border-right: none; }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- HEADER BANNER -->
    <header class="header-banner">
        <div class="header-left">
            <strong>ROYAUME DU MAROC</strong><br>
            Ministère de l'Equipement, du Transport et de la Logistique
        </div>
        <div class="header-center">
            <img src="{{ $logoPath }}" alt="Logo">
        </div>
        <div class="header-right">
            <strong>المملكة المغربية</strong><br>
            وزارة التجهيز والنقل واللوجيستيك
        </div>
    </header>

    <!-- TITLE SECTION -->
    <div class="title-container">
        <div class="ref-box">Réf. : DPL1</div>
        <div class="main-titles">
            <h1>التصريح القبلي بكراء سيارة بدون سائق</h1>
            <p class="subtitle-ar">(يعبأ من طرف المكتري القاطن بالمغرب)</p>
            <h2>Déclaration préalable de location de voiture sans chauffeur</h2>
            <p class="subtitle-fr">(à renseigner par le locataire résidant au Maroc)</p>
        </div>
    </div>

    <!-- MAIN FORM TABLE -->
    <table class="document-container">
        <tr>
            <td colspan="3" style="width: 50%;">Je soussigné(e) :</td>
            <td colspan="3" class="arabic">أنا الممضي (ة) أسفله</td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 15%;">Nom</div>
                    <div class="value" style="flex-grow: 1; text-align: left;">{{ $client?->nom }}</div>
                    <div class="arabic" style="width: 15%;">الاسم العائلي</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 15%;">Prénom (s)</div>
                    <div class="value" style="flex-grow: 1; text-align: left;">{{ $client?->prenom }}</div>
                    <div class="arabic" style="width: 15%;">الاسم الشخصي</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 30%;">N° de la C.N.I.E<br>Ou carte de séjour</td>
            <td colspan="2" style="text-align: center;"><span class="value">{{ $client?->cin }}</span></td>
            <td colspan="2" class="arabic" style="width: 30%;">رقم البطاقة الوطنية للتعريف الإلكترونية أو بطاقة الإقامة</td>
        </tr>
        <tr>
            <td colspan="2">N° du permis de conduire</td>
            <td colspan="2" style="text-align: center;"><span class="value">{{ $client?->permis_numero ?? '----------' }}</span></td>
            <td colspan="2" class="arabic">رقم رخصة السياقة</td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 10%;">Adresse</div>
                    <div class="value" style="flex-grow: 1; text-align: center; font-size: 11px;">{{ $client?->adresse ?? '-----------------------------------------' }}</div>
                    <div class="arabic" style="width: 10%;">العنوان</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 10%;">Ville</div>
                    <div class="value" style="flex-grow: 1; padding-left: 50px;">{{ $client?->ville ?? '----------' }}</div>
                    <div class="arabic" style="width: 10%;">المدينة</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <span>Code postal</span>
                    <div class="postal-container">
                        @php $zip = str_pad($client?->code_postal ?? '00000', 5, '0', STR_PAD_LEFT); @endphp
                        @foreach(str_split($zip) as $char)
                            <div class="postal-box">{{ $char }}</div>
                        @endforeach
                    </div>
                    <span class="arabic">الرمز البريدي</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 10%;">N° de GSM</div>
                    <div class="value" style="flex-grow: 1; padding-left: 50px;">{{ $client?->telephone ?? '----------' }}</div>
                    <div class="arabic" style="width: 10%;">الهاتف النقال</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <span>Adresse mail</span>
                    <span class="value" style="text-transform: lowercase;">{{ $client?->email ?? '********************' }}</span>
                    <span class="arabic">العنوان الإلكتروني</span>
                </div>
            </td>
        </tr>

        <!-- VEHICLE SECTION -->
        <tr>
            <td colspan="6" style="padding: 10px 10px; border-bottom: none;">
                <div class="flex-row" style="align-items: flex-start;">
                    <div style="width: 38%; line-height: 1.4;">
                        Déclare avoir pris en location le véhicule <strong>{{ $vehicle?->marque }} {{ $vehicle?->modele }}</strong><br>
                        Immatriculé sous numéro :<br>
                        et appartenant à l'agence de location
                    </div>
                    <div style="text-align: center; width: 24%;">
                        <div class="plate-border">{{ $vehicle?->immatriculation }}</div>
                        <span class="company-name">NOM DE VOTRE AGENCE</span>
                    </div>
                    <div class="arabic" style="width: 38%; line-height: 1.4;">
                        أصرح أنني اكتريت المركبة المسجلة <strong>{{ $vehicle?->marque }}</strong><br>
                        تحت رقم :<br>
                        والتي هي في ملكية وكالة كراء السيارات :
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="padding: 0 15px 10px 15px; border-top: none;">
                <div class="flex-row"><div class="line-segment"></div><div class="line-segment"></div></div>
                <div class="flex-row"><div class="line-segment"></div><div class="line-segment"></div></div>
                <div class="flex-row"><div class="line-segment"></div><div class="line-segment"></div></div>
            </td>
        </tr>

        <!-- DATES SECTION -->
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <span>Pour la période allant du :</span>
                    <span class="arabic">للفترة المتراوحة من :</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 35%;">Jour d'emprunt (JJ/MM/AAAA) :</div>
                    <div class="value" style="flex-grow: 1; text-align: center;">{{ $contract?->date_depart?->format('d/m/Y') }}</div>
                    <div class="arabic" style="width: 35%;">يوم تسلم المركبة :</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 35%;">Heure d'emprunt (HH:MM)</div>
                    <div class="value" style="flex-grow: 1; text-align: center;">{{ $contract?->heure_depart }}</div>
                    <div class="arabic" style="width: 35%;">ساعة تسلم المركبة :</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 35%;">Au :</div>
                    <div class="value" style="flex-grow: 1; text-align: center;">{{ $contract?->date_retour?->format('d/m/Y') }}</div>
                    <div class="arabic" style="width: 35%;">إلى :</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 35%;">Jour de restitution (JJ/MM/AAAA) :</div>
                    <div class="value" style="flex-grow: 1; text-align: center;">{{ $contract?->date_retour?->format('d/m/Y') }}</div>
                    <div class="arabic" style="width: 35%;">يوم إعادة المركبة :</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 35%;">Heure de restitution (HH:MM)</div>
                    <div class="value" style="flex-grow: 1; text-align: center;">{{ $contract?->heure_retour }}</div>
                    <div class="arabic" style="width: 35%;">ساعة إعادة المركبة :</div>
                </div>
            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td colspan="6">
                <div class="flex-row">
                    <span>Fait à : <span class="value">{{ $infraction->lieu_constat ?? 'KHOURIBGA' }}</span></span>
                    <span class="arabic">حرر ب :</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <div class="flex-row">
                    <span>Le : <span class="value">{{ $contract?->date_depart?->format('d/m/Y') }}</span></span>
                    <span class="arabic">في :</span>
                </div>
            </td>
        </tr>

        <!-- SIGNATURES -->
        <tr class="signature-row">
            <td colspan="4" class="sig-box-left">
                <div class="arabic" style="text-align: center; margin-bottom: 5px;">الإمضاء وخاتم وكالة كراء السيارات</div>
                <div style="text-align: center;">Signature et cachet de l'agence de location-</div>
            </td>
            <td colspan="2" class="sig-box-right">
                <div class="flex-row">
                    <span>Signature du locataire</span>
                    <span class="arabic">إمضاء المكتري</span>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>