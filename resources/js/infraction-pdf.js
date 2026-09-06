// public/js/infraction-pdf.js

window.loadInfractionData = async function(infractionId) {
    try {
        const response = await fetch(`/api/infractionsapi/${infractionId}`);
        const result = await response.json();
        const infraction = result.data;

        if (infraction) {
            // Remplissage des champs
            document.getElementById('client-nom').textContent = infraction.nom || '---';
            document.getElementById('client-prenom').textContent = infraction.prenom || '---';
            document.getElementById('client-cin').textContent = infraction.cin || '---';
            document.getElementById('client-permis').textContent = infraction.numero_permis || '---';
            document.getElementById('client-adresse').textContent = infraction.adresse || '---';
            document.getElementById('client-ville').textContent = infraction.ville || '---';

            const postalContainer = document.getElementById('postal-container');
            if (postalContainer) {
                const zip = String(infraction.code_postal || '00000').padStart(5, '0');
                postalContainer.innerHTML = zip.split('').map(char => `<span class="postal-box">${char}</span>`).join('');
            }
        }
    } catch (error) {
        console.error("Erreur chargement données:", error);
    }
};

window.downloadPDF = async function() {
    const { jsPDF } = window.jspdf;
    const element = document.getElementById('page-content');
    
    try {
        const canvas = await html2canvas(element, { scale: 2, useCORS: true });
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        pdf.addImage(imgData, 'PNG', 0, 0, 210, (canvas.height * 210) / canvas.width);
        pdf.save("document_location.pdf");
    } catch (e) {
        console.error("Erreur PDF:", e);
    }
};