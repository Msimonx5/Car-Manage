<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déclaration de l'auteur de l'infraction</title>
    <style>
        @page { size: A4; margin: 8mm; }
        body { font-family: "Times New Roman", Times, serif; margin: 0; padding: 0; background-color: #f0f0f0; color: #000; }
        .main-wrapper { width: 210mm; min-height: 290mm; margin: 0 auto; padding: 8mm; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); box-sizing: border-box; }

        /* ---------- En-tête du document ---------- */
        .header-banner { display: flex; justify-content: space-between; align-items: center; background-color: #eeeeee !important; padding: 6px 12px; text-align: center; border: 1.2px solid #000; border-bottom: none; }
        .header-left, .header-right { width: 38%; font-size: 11px; line-height: 1.2; }
        .header-left strong { font-size: 12.5px; }
        .header-center { width: 24%; text-align: center; }
        .header-center img { max-height: 50px; }
        .header-right { direction: rtl; font-family: Arial, sans-serif; }
        .header-right strong { font-size: 13.5px; }
        
        .title-container { position: relative; text-align: center; padding: 8px 0; border: 1.2px solid #000; border-bottom: none; }
        .ref-box { position: absolute; left: 10px; top: 8px; border: 1px solid #000; padding: 2px 8px; font-weight: bold; font-size: 11px; }
        .main-titles h1 { font-size: 17px; margin: 2px 0; font-family: Arial, sans-serif; }
        .main-titles h2 { font-size: 14px; margin: 2px 0; font-weight: bold; }
        .subtitle-ar { direction: rtl; font-size: 11px; margin: 2px 0; font-weight: normal; font-family: Arial, sans-serif; }
        .subtitle-fr { font-style: italic; font-size: 11px; margin: 2px 0; }

        /* ---------- Tableau principal ---------- */
        .document-container { 
            width: 100%; 
            table-layout: fixed; 
            border: 1.2px solid #000; 
            border-collapse: collapse; 
        }
        .document-container td { 
            border-top: 1px solid #000 !important; 
            border-bottom: 1px solid #000 !important; 
            border-left: none; 
            border-right: none; 
            padding: 4px 8px; 
            vertical-align: middle; 
            font-size: 11.5px; 
            color: #000; 
            box-sizing: border-box;
        }

        .col-left { width: 35%; }
        .col-center { width: 30%; }
        .col-right { width: 35%; }

        .row-avis td { border-left: 1px solid #000 !important; border-right: 1px solid #000 !important; }
        .row-cnie td { border-left: 1px solid #000 !important; border-right: 1px solid #000 !important; }

        .value { font-family: "Times New Roman", Times, serif !important; color: #1a3c72; font-weight: bold; font-size: 11.5px; text-transform: uppercase; text-align: center; }
        .arabic { direction: rtl; text-align: right; font-family: Arial, sans-serif; font-size: 12px; white-space: nowrap; color: #000; }
        .arabic-wrap { direction: rtl; text-align: right; font-family: Arial, sans-serif; font-size: 11.5px; white-space: normal; color: #000; line-height: 1.25; }
        .italic-note { font-style: italic; font-size: 10px; }

        .avis-col-left { width: 32%; text-align: left; }
        .avis-col-center { width: 44%; text-align: center; }
        .avis-col-right { width: 24%; text-align: right; }

        .avis-container { display: inline-flex; align-items: flex-end; justify-content: center; gap: 4px; margin: 0 auto; }
        .avis-comb { display: flex; align-items: flex-end; }
        .avis-comb .tick-cell { width: 13px; height: 18px; border-left: 1px solid #000; border-bottom: 1px solid #000; }
        .avis-comb .tick-cell:last-child { border-right: 1px solid #000; }
        .avis-rf { display: flex; height: 18px; border: 1px solid #000; margin: 0 2px; }
        .avis-rf span { width: 12px; text-align: center; line-height: 18px; font-size: 9px; font-weight: bold; color: #000; }
        .avis-rf span:first-child { border-right: 1px solid #000; }

        .thick-input-box {
            display: block; width: 100%; height: 28px; border: 2px solid #000;
            background: #fff; text-align: center; line-height: 28px; font-weight: bold;
            color: #1a3c72; font-size: 12px; text-transform: uppercase; box-sizing: border-box;
        }

        /* ---------- Zone de Signature (Espace réduit) ---------- */
        .signature-row td { 
            height: 130px; 
            vertical-align: top !important; 
            padding: 8px 10px; 
        }
        .sig-box-left {
            border-left: 1px solid #000 !important;
            border-right: 1px solid #000 !important;
        }
        .sig-box-right {
            border-right: 1px solid #000 !important;
        }
        .sig-label-row-reduced {
            display: flex;
            justify-content: flex-start; /* Alignement rapproché */
            align-items: center;
            gap: 10px; /* Espace réduit à 10px */
            width: 100%;
        }
        .sig-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* ---------- Cadres d'information du bas ---------- */
        .footer-note-container { display: flex; justify-content: space-between; width: 100%; margin-top: 15px; gap: 15px; box-sizing: border-box; }
        .footer-note-box { width: 48.5%; padding: 8px 10px; font-size: 10px; line-height: 1.35; border: 1.5px solid #000; box-sizing: border-box; background-color: #fff; }
        .footer-note-box.arabic { white-space: normal; text-align: right; font-size: 10.5px; font-family: Arial, sans-serif; }

        .footer-separator { border: none; border-top: 1.5px solid #000; margin: 18px 0 12px 0; width: 100%; }

        .bottom-warning-text { text-align: center; font-size: 10px; font-weight: bold; line-height: 1.5; }
        .bottom-warning-text p { margin: 2px 0; }

        /* ---------- Loader ---------- */
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
    document.body.classList.add('is-generating');
    try {
        loader.status('Préparation du document...');
        preparerTexteArabe();
        await attendreImages();
        await genererEtOuvrirPdf();
    } catch (error) {
        console.error(error);
        loader.fail(error.message);
    }
});

const REGEX_ARABE = /[؀-ۿݐ-ݿࢠ-ࣿﭐ-﷿ﹰ-]/;
const ESPACE_ARABE = ' ​';

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

function supprimerPagesEnTrop(pdf, element) {
    const PX_PAR_MM = 96 / 25.4;
    const hauteurRendue = element.getBoundingClientRect().height / PX_PAR_MM;
    const hauteurPage = pdf.internal.pageSize.getHeight();

    if (hauteurRendue - hauteurPage > 15) return;

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

    <header class="header-banner">
        <div class="header-left"><strong>ROYAUME DU MAROC</strong><br>Ministère de l'Equipement, du Transport et de la Logistique</div>
        <div class="header-center"><img src="{{ asset('narsa.jpeg') }}" alt="Logo"></div>
        <div class="header-right"><strong>المملكة المغربية</strong><br>وزارة التجهيز والنقل واللوجيستيك</div>
    </header>

    <div class="title-container">
        <div class="ref-box">Réf. : DA1</div>
        <div class="main-titles">
            <h1>التصريح بمرتكب المخالفة</h1>
            <p class="subtitle-ar">(خاص بالإدارات العمومية، بالمؤسسات والشركات العمومية والجماعات المحلية)</p>
            <h2>Déclaration de l'auteur de l'infraction</h2>
            <p class="subtitle-fr">(Réservé aux administrations publiques, aux établissements et entreprises publics et aux collectivités locales)</p>
        </div>
    </div>

    <table class="document-container">

        <tr class="row-avis">
            <td class="col-left avis-col-left">
                <div style="font-weight: normal; font-size: 11.5px;">N° de l'avis de contravention</div>
                <div class="italic-note">(Copie à joindre au présent formulaire)</div>
            </td>
            <td class="col-center avis-col-center">
                <div class="avis-container">
                    <div class="avis-comb">
                        <div class="tick-cell"></div><div class="tick-cell"></div><div class="tick-cell"></div>
                        <div class="tick-cell"></div><div class="tick-cell"></div><div class="tick-cell"></div>
                        <div class="tick-cell"></div><div class="tick-cell"></div><div class="tick-cell"></div>
                        <div class="tick-cell"></div>
                    </div>
                    <div class="avis-rf"><span>R</span><span>F</span></div>
                    <div class="avis-comb">
                        <div class="tick-cell"></div><div class="tick-cell"></div>
                        <div class="tick-cell"></div><div class="tick-cell"></div>
                    </div>
                </div>
            </td>
            <td class="col-right avis-col-right">
                <div class="arabic">
                    رقم الإشعار بالمخالفة<br>
                    <span class="italic-note" style="direction: rtl; display: inline-block;">&#x200F;(إرفاق نسخة من الإشعار بهذا المطبوع)&#x200F;</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2"><strong>Je soussigné(e) (Personne habilitée) :</strong></td>
            <td class="arabic"><strong>أنا الممضي (ة) أسفله (شخص له الصلاحية القانونية)</strong></td>
        </tr>

        <tr>
            <td class="col-left">Nom</td>
            <td class="col-center value" id="declarant-nom">SOULAMI</td>
            <td class="col-right arabic">الاسم العائلي</td>
        </tr>
        <tr>
            <td class="col-left">Prénom (s)</td>
            <td class="col-center value" id="declarant-prenom">EL MUSTAFA</td>
            <td class="col-right arabic">الاسم الشخصي</td>
        </tr>
        <tr>
            <td class="col-left">Fonction</td>
            <td class="col-center value" id="declarant-fonction">GÉRANT</td>
            <td class="col-right arabic">المهنة</td>
        </tr>
        <tr>
            <td class="col-left">N° de GSM</td>
            <td class="col-center value" id="declarant-gsm">+2126 61 89 55 51</td>
            <td class="col-right arabic">رقم الهاتف النقال</td>
        </tr>
        <tr>
            <td class="col-left">Adresse mail</td>
            <td class="col-center value" id="declarant-email">SOULAMIMUSTAFA74@GMAIL.COM</td>
            <td class="col-right arabic">عنوان البريد الإلكتروني</td>
        </tr>
        <tr>
            <td class="col-left">Administration</td>
            <td class="col-center value" id="declarant-administration">STE MUSTASOU NEGOCES SARL AU</td>
            <td class="col-right arabic">الإدارة</td>
        </tr>

        <tr>
            <td class="col-left" style="font-size: 11px; line-height: 1.25;">
                Déclare que le véhicule, immatriculé sous le numéro<br>
                objet de l'avis de contravention sus indiqué,<br>
                était conduit, au moment de la constatation de l'infraction par :
            </td>
            <td class="col-center" style="padding: 4px 10px;">
                <div class="thick-input-box">{{ $infraction->immatriculation ?: '3000-5-A' }}</div>
            </td>
            <td class="col-right arabic-wrap">
                أصرح أن المركبة المسجلة تحت رقم<br>
                موضوع الإشعار بالمخالفة المشار إليها<br>
                أعلاه، كانت مساقة وقت معاينة المخالفة من طرف :
            </td>
        </tr>

        <tr>
            <td class="col-left">Nom</td>
            <td class="col-center value">{{ $infraction->nom ?: 'TEST' }}</td>
            <td class="col-right arabic">الاسم العائلي</td>
        </tr>
        <tr>
            <td class="col-left">Prénom (s)</td>
            <td class="col-center value">{{ $infraction->prenom ?: 'MOUAD' }}</td>
            <td class="col-right arabic">الاسم الشخصي</td>
        </tr>
        <tr>
            <td class="col-left">Adresse</td>
            <td class="col-center value">{{ $infraction->adresse ?: '154 HEY EL PHOSPHATE' }}</td>
            <td class="col-right arabic">العنوان</td>
        </tr>
        <tr>
            <td class="col-left">Ville</td>
            <td class="col-center value">{{ $infraction->ville ?: 'BENI MELLAL KHENIFRA' }}</td>
            <td class="col-right arabic">المدينة</td>
        </tr>

        <tr>
            <td class="col-left" style="font-size: 11px;">
                <span style="float: left;">Ville</span>
                <span style="float: right;">Code postal</span>
            </td>
            <td class="col-center" style="padding: 4px 10px;">
                <div class="thick-input-box">{{ $infraction->code_postal ?: '25000' }}</div>
            </td>
            <td class="col-right arabic">
                <span style="float: left;">الرمز البريدي</span>
                <span style="float: right;">المدينة</span>
            </td>
        </tr>

        <tr class="row-cnie">
            <td class="col-left" style="font-size: 11px; line-height: 1.2;">
                N° de la C.N.I.E ou de la carte<br>
                séjour <span class="italic-note">(joindre une copie)</span>
            </td>
            <td class="col-center" style="padding: 4px 10px;">
                <div class="thick-input-box">{{ $infraction->cin ?: 'Q34433' }}</div>
            </td>
                <td class="col-right arabic-wrap">
                    رقم البطاقة الوطنية للتعريف<br>
                    الإلكترونية أو بطاقة الإقامة<br>
                    &#x200F;(إرفاق نسخة)&#x200F;
                </td>
        </tr>

        <tr>
            <td class="col-left">N° de permis de conduire <span class="italic-note">(joindre une copie)</span></td>
            <td class="col-center value">{{ $infraction->numero_permis ?: 'A12345' }}</td>
            <td class="col-right arabic">رقم رخصة السياقة &#x200F;(إرفاق نسخة)&#x200F;</td>
        </tr>

        <tr>
            <td class="col-left">Fait à :</td>
            <td class="col-center value">KHOURIBGA</td>
            <td class="col-right arabic">حرر ب :</td>
        </tr>
        <tr>
            <td class="col-left">Le :</td>
            <td class="col-center value">{{ $infraction->created_at?->format('d/m/Y') ?: '12/09/2026' }}</td>
            <td class="col-right arabic">في :</td>
        </tr>

        <!-- Zone de signature avec espace réduit -->
        <tr class="signature-row">
            <td colspan="3" style="padding: 0; border-left: 1px solid #000; border-right: 1px solid #000; height: 130px; vertical-align: top;">
                <table style="width: 100%; height: 100%; table-layout: fixed; border-collapse: collapse;">
                    <tr>
                        <td style="width: 55%; border-right: 1px solid #000; padding: 8px 10px; vertical-align: top;">
                            <div class="sig-label-row-reduced">
                                <span>Cachet de l'administration</span>
                                <span class="arabic">خاتم الإدارة</span>
                            </div>
                        </td>
                        <td style="width: 45%; padding: 8px 10px; vertical-align: top;">
                            <div class="sig-label-row">
                                <span>Signature du déclarant</span>
                                <span class="arabic">إمضاء المصرح</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer-note-container">
        <div class="footer-note-box">
            Ce formulaire, duly renseigné et signé, assorti d'une copie de l'avis de contravention objet de la déclaration et des justificatifs associés, doit être déposé, dans un délai de 30 jours à compter de la date de notification de l'avis de contravention, auprès des services du transport routier relevant des Directions Régionales ou Provinciales de l'Equipement, du Transport et de la Logistique.
        </div>
        <div class="footer-note-box arabic">
            يجب تعبئة النموذج بدقة وتوقيعه وإرفاقه بنسخة من الإشعار بالمخالفة موضوع التصريح وكذا بالوثائق المبررة وإيداعه مباشرة، داخل أجل 30 يوما ابتداء من تاريخ الإشعار بالمخالفة، بإحدى مصالح النقل الطرقي بالمديريات الجهوية أو الإقليمية للتجهيز والنقل واللوجيستيك.
        </div>
    </div>

    <hr class="footer-separator">

    <div class="bottom-warning-text">
        <p>ملحوظة : كل من أدلى بمعلومات غير صحيحة أو بوثائق مزيفة أو ساعد على ذلك سيعاقب طبقا للقوانين الجاري بها العمل.</p>
        <p>NB : Toute personne ayant fourni de faux renseignements ou documents falsifiés ou ayant aidé pour le faire sera puni conformément aux lois en vigueur.</p>
    </div>

</div>
</body>
</html>