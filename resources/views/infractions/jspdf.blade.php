<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déclaration préalable de location</title>
    <style>
        @page { size: A4; margin: 10mm; }
        body { font-family: "Times New Roman", Times, serif; margin: 0; padding: 0; background-color: #f0f0f0; color: #000; }
        .no-print-btn { position: fixed; top: 20px; right: 20px; padding: 12px 24px; background-color: #1a3c72; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; }
        .no-print-btn:hover { background-color: #122b54; }
        .main-wrapper { width: 210mm; min-height: 297mm; margin: 20px auto; padding: 10mm; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); box-sizing: border-box; }
        .header-banner { display: flex; justify-content: space-between; align-items: center; background-color: #eeeeee !important; padding: 8px 15px; text-align: center; border: 1px solid #000; border-bottom: none; }
        .header-left, .header-right { width: 40%; font-size: 11px; line-height: 1.2; }
        .header-left strong { font-size: 13px; }
        .header-center { width: 20%; }
        .header-center img { max-height: 55px; }
        .header-right { direction: rtl; font-family: Arial, sans-serif; }
        .header-right strong { font-size: 14px; }
        .title-container { position: relative; text-align: center; padding: 10px 0; border: 1px solid #000; border-top: none; }
        .ref-box { position: absolute; left: 10px; top: 10px; border: 1px solid #000; padding: 3px 10px; font-weight: bold; font-size: 12px; }
        .main-titles h1 { font-size: 18px; margin: 2px 0; font-family: Arial, sans-serif; }
        .main-titles h2 { font-size: 16px; margin: 2px 0; font-weight: bold; }
        .subtitle-ar { direction: rtl; font-size: 12px; margin: 0; font-weight: bold; font-family: Arial, sans-serif; }
        .subtitle-fr { font-style: italic; font-size: 12px; margin: 0; }
        .document-container { width: 100%; border: 1.2px solid #000; border-collapse: collapse; }
        .document-container td { border: 0.8px solid #000; padding: 5px 10px; vertical-align: middle; font-size: 12px; color: #000; }
        .value { font-family: "Times New Roman", Times, serif !important; color: #1a3c72; font-weight: bold; font-size: 12px; text-transform: uppercase; }
        .arabic { direction: rtl; text-align: right; font-family: Arial, sans-serif; font-size: 12.5px; white-space: nowrap; color: #000; }
        .flex-row { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        .postal-container { display: inline-flex; border: 1px solid #000; border-top: none; border-right: none; height: 18px; }
        .postal-box { width: 18px; border-right: 1px solid #000; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1a3c72; font-size: 11px; }
        .plate-border { border: 2.5px solid #000; display: inline-block; padding: 3px 15px; font-weight: bold; font-size: 16px; color: #1a3c72; margin-bottom: 3px; }
        .company-name { display: block; color: #1a3c72; font-weight: bold; font-size: 12px; }
        .line-segment { height: 1px; border-bottom: 0.5px solid #666; width: 48%; margin: 5px 0; }
        .signature-row td { height: 160px; vertical-align: top !important; padding: 10px; }
        .sig-box-left { width: 65%; text-align: center; border-right: 1.2px solid #000; }
        .sig-box-right { width: 35%; }
        .no-side-borders { border-left: none; border-right: none; }
    </style>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const infractionId = {{ $id }};

    try {
        const response = await fetch(`/api/infractionsapi/${infractionId}`);
        if (!response.ok) throw new Error('Erreur API: ' + response.status);

        const json = await response.json();
        const infraction = json.data; // <-- structure plate, une seule clé "data"

        // Client
        document.getElementById('client-nom').textContent = infraction.nom ?? '';
        document.getElementById('client-prenom').textContent = infraction.prenom ?? '';
        document.getElementById('client-cin').textContent = infraction.cin ?? '';
        document.getElementById('client-permis').textContent = infraction.numero_permis ?? '';
        document.getElementById('client-adresse').textContent = infraction.adresse ?? '';
        document.getElementById('client-ville').textContent = infraction.ville ?? '';
        document.getElementById('client-telephone').textContent = infraction.telephone ?? '';
        document.getElementById('client-email').textContent = infraction.email ?? '';

        // Code postal en petites cases
        const postalContainer = document.getElementById('postal-container');
        (infraction.code_postal ?? '').split('').forEach(digit => {
            const box = document.createElement('div');
            box.className = 'postal-box';
            box.textContent = digit;
            postalContainer.appendChild(box);
        });

        // Véhicule
        const vehicleFullName = `${infraction.marque ?? ''} ${infraction.modele ?? ''}`.trim();
        // document.getElementById('vehicle-full-name').textContent = vehicleFullName;
        document.getElementById('vehicle-immatriculation').textContent = infraction.immatriculation ?? '';
        // document.getElementById('vehicle-marque-ar').textContent = vehicleFullName;

        // Dates
        document.getElementById('date-depart').textContent = infraction.date_depart ?? '';
        document.getElementById('heure-depart').textContent = infraction.heure_depart ?? '';
        document.getElementById('date-retour-top').textContent = infraction.date_retour ?? '';
        document.getElementById('date-retour').textContent = infraction.date_retour ?? '';
        document.getElementById('heure-retour').textContent = infraction.heure_retour ?? '';
        document.getElementById('lieu-constat').textContent = infraction.ville ?? '';
        document.getElementById('date-signature').textContent = infraction.created_at ?? '';

        genererEtOuvrirPdf();
    } catch (error) {
        console.error(error);
        alert("Impossible de charger les données de l'infraction : " + error.message);
    }
});

function genererEtOuvrirPdf() {
    const element = document.getElementById('page-content');

    const options = {
        margin: 0,
        filename: 'declaration-location.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(options).from(element).outputPdf('blob').then((blob) => {
        const url = URL.createObjectURL(blob);
        window.location.href = url;
    });
}
</script>
<body>

{{-- <button class="no-print-btn" onclick="generatePDF()">Télécharger / Ouvrir en PDF</button> --}}

<div class="main-wrapper" id="page-content">
    <header class="header-banner">
        <div class="header-left"><strong>ROYAUME DU MAROC</strong><br>Ministère de l'Equipement, du Transport et de la Logistique</div>
        <div class="header-center"><img src="{{ asset('narsa.jpeg') }}" alt="Logo"></div>
        <div class="header-right"><strong>المملكة المغربية</strong><br>وزارة التجهيز والنقل واللوجيستيك</div>
    </header>

    <div class="title-container">
        <div class="ref-box">Réf. : DPL1</div>
        <div class="main-titles">
            <h1>التصريح القبلي بكراء سيارة بدون سائق</h1>
            <p class="subtitle-ar">(يعبأ من طرف المكتري القاطن بالمغرب)</p>
            <h2>Déclaration préalable de location de voiture sans chauffeur</h2>
            <p class="subtitle-fr">(à renseigner par le locataire résidant au Maroc)</p>
        </div>
    </div>

    <table class="document-container">
        <!-- Section Identité -->
        <tr><td colspan="3" style="width: 50%;">Je soussigné(e) :</td><td colspan="3" class="arabic">أنا الممضي (ة) أسفله</td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Nom</div><div class="value" id="client-nom" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">الاسم العائلي</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Prénom (s)</div><div class="value" id="client-prenom" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">الاسم الشخصي</div></div></td></tr>
        <tr><td colspan="2" style="width: 30%;">N° de la C.N.I.E</td><td colspan="2" style="text-align: center;"><span class="value" id="client-cin"></span></td><td colspan="2" class="arabic" style="width: 30%;">رقم البطاقة الوطنية</td></tr>
        <tr><td colspan="2">N° du permis</td><td colspan="2" style="text-align: center;"><span class="value" id="client-permis"></span></td><td colspan="2" class="arabic">رقم رخصة السياقة</td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 10%;">Adresse</div><div class="value" id="client-adresse" style="flex-grow: 1; text-align: center;"></div><div class="arabic" style="width: 10%;">العنوان</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 10%;">Ville</div><div class="value" id="client-ville" style="flex-grow: 1;"></div><div class="arabic" style="width: 10%;">المدينة</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><span>Code postal</span><div class="postal-container" id="postal-container"></div><span class="arabic">الرمز البريدي</span></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 10%;">GSM</div><div class="value" id="client-telephone" style="flex-grow: 1;"></div><div class="arabic" style="width: 10%;">الهاتف</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><span>Mail</span><span class="value" id="client-email"></span><span class="arabic">العنوان الإلكتروني</span></div></td></tr>

        <!-- Section Véhicule -->
        <tr>
            <td colspan="6" style="padding: 10px 10px; border-bottom: none;">
                <div class="flex-row" style="align-items: flex-start;">
                    <div style="width: 42%;">Déclare avoir pris en location le véhicule <strong id="vehicle-full-name"></strong></div>
                    <div style="text-align: center; width: 20%;"><div class="plate-border" id="vehicle-immatriculation"></div><span class="company-name">SOULAMI CAR</span></div>
                    <div class="arabic" style="width: 38%;">أصرح أنني اكتريت المركبة المسجلة <strong id="vehicle-marque-ar"></strong></div>
                </div>
            </td>
        </tr>
        <tr><td colspan="6" style="padding: 0 15px 10px 15px; border-top: none;"><div class="flex-row"><div class="line-segment"></div><div class="line-segment"></div></div></td></tr>

        <!-- Dates -->
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><span>Du :</span><span class="arabic">من :</span></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 35%;">Jour / Heure emprunt</div><div class="value" style="flex-grow:1; text-align:center;"><span id="date-depart"></span> - <span id="heure-depart"></span></div><div class="arabic" style="width: 35%;">يوم وساعة التسلم</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><span>Au : <span id="date-retour-top" class="value"></span></span><span class="arabic">إلى :</span></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 35%;">Jour / Heure restitution</div><div class="value" style="flex-grow:1; text-align:center;"><span id="date-retour"></span> - <span id="heure-retour"></span></div><div class="arabic" style="width: 35%;">يوم وساعة الإعادة</div></div></td></tr>

        <!-- Footer -->
        <tr><td colspan="6"><div class="flex-row"><span>Fait à : <span class="value" id="lieu-constat"></span></span><span class="arabic">حرر ب :</span></div></td></tr>
        <tr><td colspan="6"><div class="flex-row"><span>Le : <span class="value" id="date-signature"></span></span><span class="arabic">في :</span></div></td></tr>

        <tr class="signature-row">
            <td colspan="4" class="sig-box-left"><div class="arabic">الإمضاء وخاتم الوكالة</div><div>Signature et cachet de l'agence</div></td>
            <td colspan="2" class="sig-box-right"><div class="flex-row"><span>Signature</span><span class="arabic">إمضاء المكتري</span></div></td>
        </tr>
    </table>
</div>
</body>
</html>