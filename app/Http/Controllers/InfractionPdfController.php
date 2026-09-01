<?php

namespace App\Http\Controllers;

use App\Models\Infraction;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class InfractionPdfController extends Controller
{
    /**
     * --------------------------------------------------------------------------
     * Génère l'instance PDF
     * --------------------------------------------------------------------------
     */
    private function buildPdf(Infraction $infraction): PdfBuilder
    {
        $infraction->load([
            'client',
            'vehicle',
            'contract',
        ]);

        return Pdf::view('infractions.pdf', [
            'infraction' => $infraction,
        ])
        ->format('a4');
    }

    /**
     * --------------------------------------------------------------------------
     * Nom de fichier standard
     * --------------------------------------------------------------------------
     */
    private function fileName(Infraction $infraction): string
    {
        $numero = $infraction->numero_contrat ?: $infraction->id;

        return 'infraction-' .
            str_replace(['/', '\\', ' '], '-', $numero) .
            '.pdf';
    }

    /**
     * --------------------------------------------------------------------------
     * Preview
     * --------------------------------------------------------------------------
     */
    public function preview(Infraction $infraction)
    {
        return $this->buildPdf($infraction)
            ->name($this->fileName($infraction))
            ->inline();
    }

    /**
     * --------------------------------------------------------------------------
     * Download
     * --------------------------------------------------------------------------
     */
    public function download(Infraction $infraction)
    {
        return $this->buildPdf($infraction)
            ->name($this->fileName($infraction))
            ->download();
    }

    /**
     * --------------------------------------------------------------------------
     * Stream / affichage inline
     * --------------------------------------------------------------------------
     */
    public function streamPdf(Infraction $infraction)
    {
        return $this->buildPdf($infraction)
            ->name($this->fileName($infraction))
            ->inline();
    }
}
