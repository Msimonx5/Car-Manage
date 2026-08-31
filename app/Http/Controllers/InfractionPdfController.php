<?php

namespace App\Http\Controllers;

use App\Models\Infraction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Contract;

class InfractionPdfController extends Controller
{
    /**
     * --------------------------------------------------------------------------
     * Génère l'instance PDF (commun aux 3 modes)
     * --------------------------------------------------------------------------
     */
    private function buildPdf(Infraction $infraction)
    {
        $infraction->load([
            'client',
            'vehicle',
            'contract',
        ]);

        $pdf = Pdf::loadView('infractions.pdf', [
            'infraction' => $infraction,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * --------------------------------------------------------------------------
     * Nom de fichier standard
     * --------------------------------------------------------------------------
     */
    private function fileName(Infraction $infraction): string
    {
        $numero = $infraction->numero_contrat ?: $infraction->id;

        return 'infraction-' . str_replace(['/', '\\', ' '], '-', $numero) . '.pdf';
    }

    /**
     * --------------------------------------------------------------------------
     * Preview : ouvre le PDF dans un nouvel onglet (inline)
     * --------------------------------------------------------------------------
     */
    public function preview(Infraction $infraction): Response
    {
        $pdf = $this->buildPdf($infraction);

        return $pdf->stream(
            $this->fileName($infraction)
        );
    }

    /**
     * --------------------------------------------------------------------------
     * Download : force le téléchargement du fichier
     * --------------------------------------------------------------------------
     */
    public function download(Infraction $infraction): Response
    {
        $pdf = $this->buildPdf($infraction);

        return $pdf->download(
            $this->fileName($infraction)
        );
    }

    /**
     * --------------------------------------------------------------------------
     * Stream : renvoie le flux binaire brut (utile pour affichage
     * dans un <iframe>, un lecteur JS, ou un appel API/AJAX)
     * --------------------------------------------------------------------------
     */
    public function streamPdf(Infraction $infraction): StreamedResponse
    {
        $pdf = $this->buildPdf($infraction);

        $fileName = $this->fileName($infraction);

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            $fileName,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $fileName . '"',
            ]
        );
    }


}