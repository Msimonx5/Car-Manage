<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Debugbar;

class ContractPdfController extends Controller
{
    /**
     * Affichage HTML (prévisualisation dans le navigateur).
     */
    public function preview(Contract $contract)
    {
        $contract->load([
            'client',
            'vehicle',
            'secondDriver',
        ]);

        return view('contracts.pdf', [
            'contract' => $contract,
            'isPdf'    => false,
        ]);
    }

    /**
     * Affichage PDF dans le navigateur.
     */
    public function stream(Contract $contract): Response
    {
        $contract->load([
            'client',
            'vehicle',
            'secondDriver',
        ]);

        $pdf = Pdf::loadView('contracts.pdf', [
            'contract' => $contract,
            'isPdf'    => true,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream(
            'Contrat-'.$contract->numero.'.pdf'
        );
    }

    /**
     * Télécharger le PDF.
     */
    public function download(Contract $contract): Response
    {

        $contract->load([
            'client',
            'vehicle',
            'secondDriver',
        ]);

        $pdf = Pdf::loadView('contracts.pdf', [
            'contract' => $contract,
            'isPdf'    => true,
        ])->setPaper('a4', 'portrait');

        return $pdf->download(
            'Contrat-'.$contract->numero.'.pdf'
        );
    }
}