<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déclaration de l'auteur de l'infraction</title>
    <style>
        @page { size: A4; margin: 10mm; }
        body { font-family: "Times New Roman", Times, serif; margin: 0; padding: 0; background-color: #f0f0f0; color: #000; }
        .main-wrapper { width: 210mm; min-height: 290mm; margin: 0 auto; padding: 10mm; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); box-sizing: border-box; }

        /* ---------- En-tête (identique au modèle DPL1) ---------- */
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
        .main-titles h2 { font-size: 15px; margin: 2px 0; font-weight: bold; }
        .subtitle-ar { direction: rtl; font-size: 12px; margin: 2px 0; font-weight: bold; font-family: Arial, sans-serif; }
        .subtitle-ar.small { font-size: 11px; font-weight: normal; }
        .subtitle-fr { font-style: italic; font-size: 11.5px; margin: 2px 0; }

        /* ---------- Corps du document ---------- */
        .document-container { width: 100%; border: 1.2px solid #000; border-collapse: collapse; }
        .document-container td { border: 0.8px solid #000; padding: 5px 10px; vertical-align: middle; font-size: 12px; color: #000; }
        .value { font-family: "Times New Roman", Times, serif !important; color: #1a3c72; font-weight: bold; font-size: 12px; text-transform: uppercase; }
        .arabic { direction: rtl; text-align: right; font-family: Arial, sans-serif; font-size: 12.5px; white-space: nowrap; color: #000; }
        .arabic-wrap { direction: rtl; text-align: right; font-family: Arial, sans-serif; font-size: 12px; white-space: normal; color: #000; line-height: 1.5; }
        .flex-row { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        .no-side-borders { border-left: none; border-right: none; }
        .italic-note { font-style: italic; font-size: 10.5px; }

        /* Case rectangulaire (immatriculation, code postal, CNIE...) : la valeur
           s'y centre quand elle est connue, la case reste vide sinon. */
        .input-box { display: inline-block; border: 1px solid #000; height: 18px; vertical-align: middle; background: #fff;
            text-align: center; line-height: 18px; font-weight: bold; color: #1a3c72; font-size: 11px; text-transform: uppercase; }

        /* Cases numéro d'avis de contravention (style "peigne" comme sur le formulaire officiel) */
        .avis-container { display: flex; align-items: flex-end; gap: 8px; border-bottom: 1px solid #000; flex-shrink: 0; }
        .avis-comb { display: flex; align-items: flex-end; }
        .avis-comb .tick-cell { width: 14px; height: 13px; border-left: 1px solid #000; }
        .avis-comb .tick-cell:last-child { border-right: 1px solid #000; }
        .avis-comb .tick-cell.filled { display: flex; align-items: flex-end; justify-content: center; padding-bottom: 1px; font-weight: bold; color: #1a3c72; font-size: 10px; }
        .avis-rf { display: flex; height: 15px; border-left: 1px solid #000; border-right: 1px solid #000; }
        .avis-rf span { width: 14px; text-align: center; line-height: 15px; font-size: 10.5px; font-weight: bold; color: #000; }
        .avis-rf span:first-child { border-right: 1px solid #000; }

        .section-title td { background-color: #f5f5f5 !important; font-weight: bold; text-align: center; }

        /* 140px plutot que 170 : le document tient ainsi sous les 297 mm de la
           page A4, avertissement final compris. */
        .signature-row td { height: 140px; vertical-align: top !important; padding: 10px; }
        .sig-box-left { width: 50%; text-align: center; border-right: 1.2px solid #000; }
        .sig-box-right { width: 50%; text-align: center; }
        .sig-label-row { display: flex; justify-content: space-between; }

        .footer-note-container { display: flex; width: 100%; border: 1.2px solid #000; border-top: none; }
        .footer-note-box { width: 50%; padding: 10px 12px; font-size: 10.5px; line-height: 1.5; }
        .footer-note-box:first-child { border-right: 1.2px solid #000; }
        /* Selecteur compose et non descendant : la classe arabic est portee par
           la boite elle-meme. En descendant, le white-space: nowrap de .arabic
           l'emportait et le paragraphe debordait sur la colonne francaise. */
        .footer-note-box.arabic { white-space: normal; text-align: right; font-size: 11px; }

        .bottom-warning { border: 1.2px solid #000; border-top: none; padding: 8px 10px; font-size: 10.5px; }
        .bottom-warning p { margin: 3px 0; }
        .bottom-warning .ar { direction: rtl; text-align: right; font-family: Arial, sans-serif; }

        /* --- Écran de chargement (le document reste masqué pendant le remplissage) --- */
        body.is-generating { overflow: hidden; }
        #pdf-loader { position: fixed; inset: 0; z-index: 99999; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 18px; background: #f6f7fb; font-family: Arial, Helvetica, sans-serif; }
        #pdf-loader .spinner { width: 54px; height: 54px; border: 5px solid #dfe3ee; border-top-color: #1a3c72; border-radius: 50%; animation: pdf-spin 0.9s linear infinite; }
        @keyframes pdf-spin { to { transform: rotate(360deg); } }
        #pdf-loader .loader-title { font-size: 17px; font-weight: bold; color: #1a3c72; margin: 0; }
        #pdf-loader .loader-status { font-size: 13px; color: #5a6478; margin: 0; min-height: 18px; }
        #pdf-loader .loader-error { display: none; max-width: 420px; text-align: center; color: #b3261e; font-size: 13px; line-height: 1.5; }
        #pdf-loader.has-error .spinner, #pdf-loader.has-error .loader-status { display: none; }
        #pdf-loader.has-error .loader-title { color: #b3261e; }
        #pdf-loader.has-error .loader-error { display: block; }
        #pdf-loader.has-error .retry-btn { display: inline-block; }
        #pdf-loader .retry-btn { display: none; margin-top: 6px; padding: 9px 18px; background: #1a3c72; color: #fff; border: none; border-radius: 5px; font-size: 13px; cursor: pointer; }
    </style>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
const loader = {
    el: null,
    status(text) {
        if (!this.el) this.el = document.getElementById('pdf-loader');
        const s = this.el && this.el.querySelector('.loader-status');
        if (s) s.textContent = text;
    },
    fail(message) {
        if (!this.el) this.el = document.getElementById('pdf-loader');
        if (!this.el) return;
        this.el.classList.add('has-error');
        this.el.querySelector('.loader-title').textContent = "Impossible de générer le document";
        this.el.querySelector('.loader-error').textContent = message;
    }
};

document.addEventListener('DOMContentLoaded', async () => {
    const infractionId = {{ $id }};
    document.body.classList.add('is-generating');

    try {
        loader.status('Récupération des données…');
        const response = await fetch(`/api/infractionsapi/${infractionId}`);
        if (!response.ok) throw new Error('Erreur API: ' + response.status);

        const json = await response.json();
        const infraction = json.data;

        loader.status('Remplissage du document…');

        /*
         * Le conducteur déclaré est le client du contrat : c'est lui qui tenait
         * le volant au moment de la constatation de l'infraction.
         */
        document.getElementById('conducteur-nom').textContent = infraction.nom ?? '';
        document.getElementById('conducteur-prenom').textContent = infraction.prenom ?? '';
        document.getElementById('conducteur-adresse').textContent = infraction.adresse ?? '';
        document.getElementById('conducteur-permis').textContent = infraction.numero_permis ?? '';

        const ville = valeurOuDefaut(infraction.ville, VILLE_PAR_DEFAUT);
        document.getElementById('conducteur-ville-1').textContent = ville;
        document.getElementById('conducteur-ville-2').textContent = ville;

        document.getElementById('conducteur-code-postal-box').textContent =
            valeurOuDefaut(infraction.code_postal, CODE_POSTAL_PAR_DEFAUT);
        document.getElementById('conducteur-cin-box').textContent = infraction.cin ?? '';

        // Véhicule concerné par l'avis de contravention
        document.getElementById('vehicle-immatriculation-box').textContent = infraction.immatriculation ?? '';

        // Lieu et date de rédaction
        document.getElementById('lieu-declaration').textContent = VILLE_AGENCE;
        document.getElementById('date-declaration').textContent = infraction.created_at ?? '';

        preparerTexteArabe();
        await attendreImages();
        await genererEtOuvrirPdf();
    } catch (error) {
        console.error(error);
        loader.fail(error.message);
    }
});

// « Fait à » désigne le lieu de rédaction du document, c'est-à-dire la ville de l'agence.
const VILLE_AGENCE = 'KHOURIBGA';

// Valeurs fixes utilisées quand la fiche client ne renseigne ni ville ni code postal.
const VILLE_PAR_DEFAUT = 'KHOURIBGA';
const CODE_POSTAL_PAR_DEFAUT = '25000';

function valeurOuDefaut(valeur, defaut) {
    return (valeur ?? '').toString().trim() || defaut;
}

// html2canvas perd les espaces des textes RTL : on les remplace par des
// espaces insécables, que le rendu conserve.
const REGEX_ARABE = /[؀-ۿݐ-ݿࢠ-ࣿﭐ-﷿ﹰ-﻿]/;
const ESPACE_ARABE = ' ​';

function preparerTexteArabe() {
    const racine = document.getElementById('page-content');
    const parcours = document.createTreeWalker(racine, NodeFilter.SHOW_TEXT);
    let noeud;
    while ((noeud = parcours.nextNode())) {
        if (REGEX_ARABE.test(noeud.nodeValue) && noeud.nodeValue.includes(' ')) {
            noeud.nodeValue = noeud.nodeValue.replace(/ /g, ESPACE_ARABE);
        }
    }
}

// Évite un PDF avec un logo manquant : on attend le chargement des images.
function attendreImages() {
    const images = Array.from(document.querySelectorAll('#page-content img'));
    return Promise.all(images.map(img => img.complete
        ? Promise.resolve()
        : new Promise(resolve => { img.onload = img.onerror = resolve; })
    ));
}

function genererEtOuvrirPdf() {
    loader.status('Génération du PDF…');
    const element = document.getElementById('page-content');

    const options = {
        margin: 0,
        filename: 'declaration-auteur-infraction.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    return html2pdf().set(options).from(element).toPdf().get('pdf').then((pdf) => {
        supprimerPagesEnTrop(pdf, element);
        loader.status('Ouverture du document…');
        const url = URL.createObjectURL(pdf.output('blob'));
        window.location.href = url;
    });
}

// Le formulaire DA1 tient sur une seule page A4. html2pdf ajoute une seconde
// page vide dès que le rendu dépasse la hauteur de page, même d'une fraction de
// millimètre : on la retire. Un débordement réel (contenu en trop) est conservé.
function supprimerPagesEnTrop(pdf, element) {
    const PX_PAR_MM = 96 / 25.4;
    const hauteurRendue = element.getBoundingClientRect().height / PX_PAR_MM;
    const hauteurPage = pdf.internal.pageSize.getHeight();

    if (hauteurRendue - hauteurPage > 15) {
        return;
    }

    for (let page = pdf.internal.getNumberOfPages(); page > 1; page--) {
        pdf.deletePage(page);
    }
}
</script>
<body>

<div id="pdf-loader">
    <div class="spinner"></div>
    <p class="loader-title">Préparation de la déclaration…</p>
    <p class="loader-status">Chargement…</p>
    <div class="loader-error"></div>
    <button type="button" class="retry-btn" onclick="window.location.reload()">Réessayer</button>
</div>

<div class="main-wrapper" id="page-content">

    <!-- ===== En-tête (identique au modèle DPL1) ===== -->
    <header class="header-banner">
        <div class="header-left"><strong>ROYAUME DU MAROC</strong><br>Ministère de l'Equipement, du Transport et de la Logistique</div>
        <div class="header-center"><img src="{{ asset('narsa.jpeg') }}" alt="Logo"></div>
        <div class="header-right"><strong>المملكة المغربية</strong><br>وزارة التجهيز والنقل واللوجيستيك</div>
    </header>

    <div class="title-container">
        <div class="ref-box">Réf. : DA1</div>
        <div class="main-titles">
            <h1>التصريح بمرتكب المخالفة</h1>
            <p class="subtitle-ar small">(خاص بالإدارات العمومية، بالمؤسسات والشركات العمومية والجماعات المحلية)</p>
            <h2>Déclaration de l'auteur de l'infraction</h2>
            <p class="subtitle-fr">(Réservé aux administrations publiques, aux établissements et entreprises publics et aux collectivités locales)</p>
        </div>
    </div>

    <table class="document-container">

        <!-- N° de l'avis de contravention -->
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div>
                        <div>N° de l'avis de contravention</div>
                        <div class="italic-note">(Copie à joindre au présent formulaire)</div>
                    </div>
                    <div class="avis-container" id="avis-container">
                        <div class="avis-comb" id="avis-group-1">
                            <div class="tick-cell"></div><div class="tick-cell"></div><div class="tick-cell"></div>
                            <div class="tick-cell"></div><div class="tick-cell"></div><div class="tick-cell"></div>
                            <div class="tick-cell"></div><div class="tick-cell"></div><div class="tick-cell"></div>
                            <div class="tick-cell"></div>
                        </div>
                        <div class="avis-rf"><span>R</span><span>F</span></div>
                        <div class="avis-comb" id="avis-group-2">
                            <div class="tick-cell"></div><div class="tick-cell"></div>
                            <div class="tick-cell"></div><div class="tick-cell"></div>
                        </div>
                    </div>
                    <div class="arabic" style="text-align:right; flex-shrink:0;">رقم الإشعار بالمخالفة<br><span class="italic-note" style="direction: rtl; white-space: nowrap;">( إرفاق نسخة من هذا الإشعار المطبوع )</span></div>
                </div>
            </td>
        </tr>

        <!-- Déclarant -->
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><span>Je soussigné(e) (Personne habilitée) :</span><span class="arabic">أنا الممضي (ة) أسفله (شخص له الصلاحية القانونية)</span></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Nom</div><div class="value" id="declarant-nom" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">الاسم العائلي</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Prénom (s)</div><div class="value" id="declarant-prenom" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">الاسم الشخصي</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Fonction</div><div class="value" id="declarant-fonction" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">المهنة</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">N° de GSM</div><div class="value" id="declarant-gsm" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">رقم الهاتف النقال</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Adresse mail</div><div class="value" id="declarant-email" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">عنوان البريد الإلكتروني</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Administration</div><div class="value" id="declarant-administration" style="flex-grow: 1;">{{ auth()->user()?->tenant?->name }}</div><div class="arabic" style="width: 15%;">الإدارة</div></div></td></tr>

        <!-- Véhicule / conducteur -->
        <tr>
            {{-- Deux colonnes en flex plutot qu'un tableau imbrique : html2canvas
                 superpose le texte RTL et le texte justifie d'un tableau interne. --}}
            <td colspan="6" style="padding: 8px 10px;">
                <div class="flex-row" style="align-items: flex-start; gap: 12px;">
                    <div style="width: 58%; font-size: 12px;">
                        Déclare que le véhicule, immatriculé sous le numéro
                        <span class="input-box" id="vehicle-immatriculation-box" style="width: 130px; margin: 0 4px;"></span>
                        objet de l'avis de contravention sus indiqué, était conduit, au moment de la constatation de l'infraction par :
                    </div>
                    <div class="arabic-wrap" dir="rtl" style="width: 42%;">
                        أصرح أن المركبة المسجلة تحت رقم موضوع الإشعار بالمخالفة المشار إليها أعلاه، كانت مساقة وقت معاينة المخالفة من طرف :
                    </div>
                </div>
            </td>
        </tr>

        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Nom</div><div class="value" id="conducteur-nom" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">الاسم العائلي</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Prénom (s)</div><div class="value" id="conducteur-prenom" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">الاسم الشخصي</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Adresse</div><div class="value" id="conducteur-adresse" style="flex-grow: 1; text-align:center;"></div><div class="arabic" style="width: 15%;">العنوان</div></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><div style="width: 15%;">Ville</div><div class="value" id="conducteur-ville-1" style="flex-grow: 1;"></div><div class="arabic" style="width: 15%;">المدينة</div></div></td></tr>

        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 15%;">Ville</div>
                    <div class="value" id="conducteur-ville-2" style="width: 20%;"></div>
                    <div style="width: 15%;">Code postal</div>
                    <div class="input-box" id="conducteur-code-postal-box" style="width: 110px;"></div>
                    <div class="arabic" style="width: 10%;">الرمز البريدي</div>
                    <div class="arabic" style="width: 15%;">المدينة</div>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="6" class="no-side-borders">
                {{-- Le libelle et la case ne tiennent pas sur une ligne : la case
                     passe dessous, centree. Le libelle arabe est laisse libre de
                     revenir a la ligne, sinon il impose sa largeur a la rangee. --}}
                <div class="flex-row" style="gap: 10px;">
                    <div style="width: 55%;">
                        <div>N° de la C.N.I.E ou de la carte séjour <span class="italic-note">(joindre une copie)</span> :</div>
                        <div style="text-align: center;"><span class="input-box" id="conducteur-cin-box" style="width: 190px;"></span></div>
                    </div>
                    <div class="arabic-wrap" style="width: 45%;">رقم البطاقة الوطنية للتعريف الإلكترونية أو بطاقة الإقامة ( إرفاق نسخة)</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="no-side-borders">
                <div class="flex-row">
                    <div style="width: 55%;">N° de permis de conduire <span class="italic-note">(joindre une copie)</span> : <span class="value" id="conducteur-permis"></span></div>
                    <div class="arabic" style="width: 45%;">رقم رخصة السياقة ( إرفاق نسخة )</div>
                </div>
            </td>
        </tr>

        <!-- Fait à / Le -->
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><span>Fait à : <span class="value" id="lieu-declaration"></span></span><span class="arabic">حرر ب :</span></div></td></tr>
        <tr><td colspan="6" class="no-side-borders"><div class="flex-row"><span>Le : <span class="value" id="date-declaration"></span></span><span class="arabic">في :</span></div></td></tr>

        <!-- Signatures -->
        <tr class="signature-row">
            <td colspan="3" class="sig-box-left">
                <div class="sig-label-row"><span>Cachet de l'administration</span><span class="arabic">خاتم الإدارة</span></div>
            </td>
            <td colspan="3" class="sig-box-right">
                <div class="sig-label-row"><span>Signature du déclarant</span><span class="arabic">إمضاء المصرح</span></div>
            </td>
        </tr>
    </table>

    <!-- Encadré : délai de dépôt -->
    <div class="footer-note-container">
        <div class="footer-note-box">
            Ce formulaire, dûment renseigné et signé, assorti d'une copie de l'avis de contravention objet de la déclaration et des justificatifs associés, doit être déposé, dans un délai de 30 jours à compter de la date de notification de l'avis de contravention, auprès des services du transport routier relevant des Directions Régionales ou Provinciales de l'Equipement, du Transport et de la Logistique.
        </div>
        <div class="footer-note-box arabic">
            يجب تعبئة النموذج بدقة وتوقيعه وإرفاقه بنسخة من الإشعار بالمخالفة موضوع التصريح وكذا بالوثائق المبررة وإيداعه مباشرة، داخل أجل 30 يوما ابتداء من تاريخ الإشعار بالمخالفة، بإحدى مصالح النقل الطرقي بالمديريات الجهوية أو الإقليمية للتجهيز والنقل واللوجيستيك.
        </div>
    </div>

    <!-- Avertissement final -->
    <div class="bottom-warning">
        <p style="text-align:center; font-weight:bold;">
            ملحوظة : كل من أدلى بمعلومات غير صحيحة أو بوثائق مزيفة أو ساعد على ذلك سيعاقب طبقا للقوانين الجاري بها العمل.
        </p>
        <p style="text-align:center; font-weight:bold;">
            NB : Toute personne ayant fourni de faux renseignements ou documents falsifiés ou ayant aidé pour le faire sera puni conformément aux lois en vigueur.
        </p>
    </div>

</div>
</body>
</html>
