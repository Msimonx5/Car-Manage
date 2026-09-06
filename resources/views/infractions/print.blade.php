@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="mb-0">Aperçu du document</h3>
            <small class="text-muted">Déclaration préalable de location — Infraction #{{ $infractionId }}</small>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>

            <button type="button" class="btn btn-info text-white" onclick="viewPDF()">
                <i class="bi bi-eye"></i> Ouvrir dans le lecteur
            </button>

            <button type="button" class="btn btn-success" onclick="downloadPDF()">
                <i class="bi bi-download"></i> Télécharger
            </button>

            <div class="input-group input-group-sm" style="width: 130px;">
                <span class="input-group-text">Copies</span>
                <input type="number" id="nbCopies" class="form-control" value="2" min="1" max="20">
            </div>

            <button type="button" class="btn btn-warning" onclick="printPDF(document.getElementById('nbCopies').value)">
                <i class="bi bi-printer"></i> Imprimer
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <iframe
                id="docFrame"
                src="{{ route('infractions.jspdf', $infractionId) }}"
                style="width: 100%; height: 85vh; border: none;"
                title="Aperçu déclaration"
            ></iframe>
        </div>
    </div>
</div>
@endsection