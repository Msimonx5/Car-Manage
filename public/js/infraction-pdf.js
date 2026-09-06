window.currentInfractionId = null;

// --- 0. Utilitaire : récupère le bon document (celui de l'iframe si présent, sinon le document courant) ---
function getTargetDocument() {
    const iframe = document.getElementById('docFrame');
    if (iframe && iframe.contentDocument) {
        return iframe.contentDocument;
    }
    return document;
}

// --- 1. Chargement des données depuis l'API ---
// Utilisé quand jspdf.blade.php est chargé seul (via sa propre route, dans l'iframe)
window.loadInfraction = async function (id) {
    window.currentInfractionId = id;
    try {
        const response = await fetch(`/api/infractionsapi/${id}`);
        const result = await response.json();
        const data = result.data;
        if (!data) return;

        const setText = (elId, val) => {
            const el = document.getElementById(elId);
            if (el) el.textContent = val || '---';
        };

        setText('client-nom', data.nom);
        setText('client-prenom', data.prenom);
        setText('client-cin', data.cin);
        setText('client-permis', data.numero_permis);
        setText('client-adresse', data.adresse);
        setText('client-ville', data.ville);
        setText('client-telephone', data.telephone);
        setText('client-email', data.email);
        setText('vehicle-immatriculation', data.immatriculation);
        setText('vehicle-full-name', data.vehicule_nom);
        setText('vehicle-marque-ar', data.vehicule_nom);
        setText('date-depart', data.date_depart);
        setText('heure-depart', data.heure_depart);
        setText('date-retour-top', data.date_retour);
        setText('date-retour', data.date_retour);
        setText('heure-retour', data.heure_retour);
        setText('lieu-constat', data.lieu);
        setText('date-signature', data.date_signature);
        // ajoute ici d'autres champs si besoin

        const postalContainer = document.getElementById('postal-container');
        if (postalContainer) {
            const zip = String(data.code_postal || '00000').padStart(5, '0');
            postalContainer.innerHTML = zip.split('')
                .map(c => `<span class="postal-box">${c}</span>`)
                .join('');
        }
    } catch (e) {
        console.error('Erreur chargement infraction:', e);
    }
};

// --- 2. Fonction interne : capture le HTML en PDF (1 page) ---
// Cherche #page-content dans l'iframe #docFrame si elle existe, sinon dans le document courant
async function captureAsPDF() {
    const { jsPDF } = window.jspdf;
    const targetDoc = getTargetDocument();
    const element = targetDoc.getElementById('page-content');

    if (!element) {
        throw new Error('Element #page-content introuvable (iframe non chargée ?)');
    }

    const canvas = await html2canvas(element, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff',
        // Nécessaire quand l'élément capturé est dans un iframe cross-context (même origine ici, mais robustifie)
        windowWidth: element.scrollWidth,
        windowHeight: element.scrollHeight
    });

    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF('p', 'mm', 'a4');
    const imgWidth = 210;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
    return { pdf, imgData, imgWidth, imgHeight };
}

// --- 3. Bouton "Ouvrir dans le lecteur" (redirige direct dans le navigateur) ---
window.viewPDF = async function () {
    try {
        const { pdf } = await captureAsPDF();
        const blob = pdf.output('blob');
        const url = URL.createObjectURL(blob);
        window.open(url, '_blank');
    } catch (e) {
        console.error('Erreur PDF (vue navigateur):', e);
        alert("Impossible d'ouvrir le PDF.");
    }
};

// --- 4. Bouton "Télécharger" ---
window.downloadPDF = async function () {
    try {
        const { pdf } = await captureAsPDF();
        pdf.save(`document_location_${window.currentInfractionId || ''}.pdf`);
    } catch (e) {
        console.error('Erreur PDF (téléchargement):', e);
        alert('Impossible de télécharger le PDF.');
    }
};

// --- 5. Bouton "Imprimer" avec N copies (par défaut 2, modifiable) ---
window.printPDF = async function (copies) {
    const nbCopies = parseInt(copies, 10) > 0 ? parseInt(copies, 10) : 2;

    try {
        const { pdf, imgData, imgWidth, imgHeight } = await captureAsPDF();

        // Duplique la page N fois dans le même PDF
        for (let i = 1; i < nbCopies; i++) {
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
        }

        const blob = pdf.output('blob');
        const url = URL.createObjectURL(blob);

        // On charge le PDF (avec ses N pages) dans un iframe caché
        // puis on déclenche l'impression native du navigateur
        const printFrame = document.createElement('iframe');
        printFrame.style.display = 'none';
        printFrame.src = url;
        document.body.appendChild(printFrame);

        printFrame.onload = function () {
            setTimeout(() => {
                printFrame.contentWindow.focus();
                printFrame.contentWindow.print();
            }, 300);
        };
    } catch (e) {
        console.error('Erreur impression:', e);
        alert("Impossible de lancer l'impression.");
    }
};