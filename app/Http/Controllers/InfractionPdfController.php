<?php

namespace App\Http\Controllers;

use App\Models\Infraction;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;
use Spatie\Browsershot\Browsershot;

class InfractionPdfController extends Controller
{
    /**
     * --------------------------------------------------------------------------
     * Génère l'instance PDF
     * --------------------------------------------------------------------------
     */
    private function buildPdf(Infraction $infraction): PdfBuilder
    {
        $html = view('infractions.pdf', compact('infraction'))->render();

        $pdf = Browsershot::html($html)
            ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
            ->timeout(60)
            ->noSandbox()
            ->showBackground()
            ->format('A4')
            ->pdf();
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
        $html = view('infractions.pdf', compact('infraction'))->render();

        $pdf = Browsershot::html($html)
            ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
            ->timeout(60)
            ->noSandbox()
            ->showBackground()
            ->format('A4')
            ->pdf();
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
        $html = view('infractions.pdf', compact('infraction'))->render();
        Browsershot::html($html)
        ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
        ->timeout(60)
        ->noSandbox()
        ->showBackground()
        ->pdf();
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
        $html = view('infractions.pdf', compact('infraction'))->render();
//  ↑ ceci = le contenu HTML de ton document (texte, tableau, champs remplis...)

            $pdf = Browsershot::html($html)                          // on donne le HTML à convertir
                ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
                 // on dit où trouver Chrome
                ->timeout(60)
                ->noSandbox()
                ->showBackground()
                ->format('A4')
                ->pdf();
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
        $html = view('infractions.pdf', compact('infraction'))->render();

        $pdf = Browsershot::html($html)
            ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
            ->timeout(60)
            ->noSandbox()
            ->showBackground()
            ->format('A4')
            ->pdf();
        return $this->buildPdf($infraction)
            ->name($this->fileName($infraction))
            ->inline();
    }
}
