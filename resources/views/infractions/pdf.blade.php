{{--
    resources/views/contracts/declaration-prealable.blade.php

    Variables attendues (à passer depuis le contrôleur) :
    - $contract  : instance de Contract, chargée avec ->client et ->vehicle
    - $agenceNom : nom de l'agence de location (ex: "SOULAMI CAR")
    - $agenceVille : ville où la déclaration est établie (ex: "KHOURIBGA")

    Exemple dans le contrôleur :

        $contract = Contract::with(['client', 'vehicle'])->findOrFail($id);

        return Pdf::loadView('contracts.declaration-prealable', [
            'contract'   => $contract,
            'agenceNom'  => 'SOULAMI CAR',
            'agenceVille'=> 'KHOURIBGA',
        ]);
--}}
@php
    $client  = $infraction->client;
    $vehicle = $infraction->vehicle;

    // Découpage nom/prénom (le formulaire officiel sépare les 2)
    $nom    = $client->nom;
    $prenom = $client->prenom;

    // Formatage dates/heures
    $dateDepart = $infraction->date_depart?->format('d/m/Y');
    $heureDepart = $infraction->heure_depart
        ? \Illuminate\Support\Str::substr($infraction->heure_depart, 0, 5)
        : '';

    $dateRetour = $infraction->date_retour?->format('d/m/Y');
    $heureRetour = $infraction->heure_retour
        ? \Illuminate\Support\Str::substr($infraction->heure_retour, 0, 5)
        : '';

    $dateDeclaration = now()->format('d/m/Y');

    $arShaper = new \ArPHP\I18N\Arabic();
    $ar = fn (string $text) => $arShaper->utf8Glyphs($text);
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Déclaration préalable — {{ $infraction->numero }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            color: #000;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10pt;
        }

        .header-table td {
            vertical-align: middle;
        }

        .header-fr {
            text-align: left;
            font-weight: bold;
            font-size: 11pt;
        }

        .header-ar {
            text-align: right;
            font-weight: bold;
            font-size: 11pt;
            direction: rtl;
        }

        .ref-line {
            margin: 10pt 0 20pt;
        }

        .ref-line .ref-fr {
            font-weight: bold;
            text-decoration: underline;
        }

        .ref-line .ref-ar {
            float: right;
            font-weight: bold;
            font-size: 14pt;
            direction: rtl;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin: 10pt 0 2pt;
        }

        .subtitle {
            text-align: center;
            font-style: italic;
            font-size: 10pt;
            margin-bottom: 15pt;
        }

        .note-ar {
            text-align: right;
            direction: rtl;
            font-size: 10pt;
            margin-bottom: 10pt;
        }

        table.form-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.form-table td {
            border: 1px solid #000;
            padding: 4pt 6pt;
            vertical-align: top;
        }

        .label-fr {
            font-size: 10.5pt;
        }

        .label-ar {
            direction: rtl;
            text-align: right;
            font-size: 10.5pt;
        }

        .value {
            font-weight: bold;
            color: #1f497d;
        }

        .signature-row td {
            height: 90pt;
        }
    </style>
</head>
<body>

    {{-- En-tête bilingue --}}
    <table class="header-table">
        <tr>
            <td class="header-fr" style="width:55%">
                ROYAUME DU MAROC<br>
                Ministère de l'Equipement, du Transport et de la Logistique
            </td>
            <td class="header-ar" style="width:45%">
                المملكة المغربية<br>
                وزارة التجهيز والنقل واللوجستيك
            </td>
        </tr>
    </table>

    {{-- Référence --}}
    <div class="ref-line">
        <span class="ref-ar">التصريح القبلي بكراء سيارة بدون سائق</span>
        <span class="ref-fr">Réf. : DPL1</span>
    </div>

    <div class="note-ar">
        )يعبأ من طرف المكتري القاطن بالمغرب)
    </div>

    <div class="title">
        Déclaration préalable de location de voiture sans chauffeur
    </div>
    <div class="subtitle">
        (à renseigner par le locataire résidant au Maroc)
    </div>

    {{-- Tableau principal --}}
    <table class="form-table">

        <tr>
            <td colspan="2">
                <span class="label-fr">Je soussigné(e) :</span>
                <span class="label-ar" style="float:right">أنا الممضي (ة) أسفله</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Nom&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $nom }}</span>
                <span class="label-ar" style="float:right">الاسم العائلي</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Prénom(s)&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $prenom }}</span>
                <span class="label-ar" style="float:right">الاسم الشخصي</span>
            </td>
        </tr>

        <tr>
            <td style="width:60%">
                <span class="label-fr">N° de la C.N.I.E ou carte de séjour&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $client->cin }}</span>
            </td>
            <td style="width:40%">
                <span class="label-ar">رقم البطاقة الوطنية للتعريف الإلكترونية أو بطاقة الإقامة</span>
            </td>
        </tr>

        <tr>
            <td style="width:60%">
                <span class="label-fr">N° du permis de conduire&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $client->numero_permis }}</span>
            </td>
            <td style="width:40%">
                <span class="label-ar">رقم رخصة السياقة</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Adresse&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $client->adresse }}</span>
                <span class="label-ar" style="float:right">العنوان</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Ville&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $client->ville }}</span>
                <span class="label-ar" style="float:right">المدينة</span>
            </td>
        </tr>

        <tr>
            <td style="width:60%">
                <span class="label-fr">Code postal&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $client->code_postal }}</span>
            </td>
            <td style="width:40%">
                <span class="label-ar">الرمز البريدي</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">N° de GSM&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $client->telephone }}</span>
                <span class="label-ar" style="float:right">الهاتف النقال</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Adresse mail&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $client->email }}</span>
                <span class="label-ar" style="float:right">العنوان الإلكتروني</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p class="label-fr" style="margin:0 0 4pt">
                    Déclare avoir pris en location le véhicule
                    <span class="label-ar" style="float:right">أصرح أنني اكتريت المركبة المسجلة</span>
                </p>
                <p class="label-fr" style="margin:0 0 4pt">
                    Immatriculé sous numéro :
                    <span class="value">{{ $vehicle->immatriculation }}</span>
                </p>
                <p class="label-fr" style="margin:0">
                    et appartenant à l'agence de location :
                    <span class="value">SOULAMI CAR</span>
                    <span class="label-ar" style="float:right">والتي هي في ملكية وكالة كراء السيارات</span>
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Pour la période allant du :</span>
                <span class="label-ar" style="float:right">للفترة المتراوحة من</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Jour d'emprunt (JJ/MM/AAAA) :&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $dateDepart }}</span>
                <span class="label-ar" style="float:right">يوم تسلم المركبة</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Heure d'emprunt (HH:MM) :&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $heureDepart }}</span>
                <span class="label-ar" style="float:right">ساعة تسلم المركبة</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Au :&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $dateRetour }}</span>
                <span class="label-ar" style="float:right">إلى</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Jour de restitution (JJ/MM/AAAA) :&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $dateRetour }}</span>
                <span class="label-ar" style="float:right">يوم إعادة المركبة</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Heure de restitution (HH:MM) :&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $heureRetour }}</span>
                <span class="label-ar" style="float:right">ساعة إعادة المركبة</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Fait à :&nbsp;&nbsp;&nbsp;</span>
                <span class="value">khouribga</span>
                <span class="label-ar" style="float:right">حرر ب</span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label-fr">Le :&nbsp;&nbsp;&nbsp;</span>
                <span class="value">{{ $dateDeclaration }}</span>
                <span class="label-ar" style="float:right">في</span>
            </td>
        </tr>

        <tr class="signature-row">
            <td style="width:55%">
                <p class="label-ar">الإمضاء وخاتم وكالة كراء السيارات</p>
                <p class="label-fr">Signature et cachet de l'agence de location</p>
            </td>
            <td style="width:45%">
                <p class="label-fr">Signature du locataire</p>
                <p class="label-ar">إمضاء المكتري</p>
            </td>
        </tr>

    </table>

</body>
</html>