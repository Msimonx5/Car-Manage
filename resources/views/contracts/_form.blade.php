@php
    $modes = ['Espèces', 'Carte bancaire', 'Virement', 'Chèque'];
    $curMode = old('mode_paiement', $contract->mode_paiement ?? 'Espèces');
@endphp

{{-- =================== PARTIES =================== --}}
<div class="section-title"><i class="bi bi-people"></i> Conducteurs</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Client <span class="req">*</span></label>
        <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @enderror">
            <option value="">Sélectionner...</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" @selected(old('client_id', $contract->client_id ?? '') == $client->id)>{{ $client->nom }} {{ $client->prenom }}</option>
            @endforeach
        </select>
        @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Deuxième conducteur</label>
        <select name="second_driver_id" class="form-select">
            <option value="">Aucun</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" @selected(old('second_driver_id', $contract->second_driver_id ?? '') == $client->id)>{{ $client->nom }} {{ $client->prenom }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- =================== VÉHICULE =================== --}}
<div class="section-title"><i class="bi bi-car-front"></i> Véhicule</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Véhicule <span class="req">*</span></label>
        <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror">
            <option value="">Sélectionner...</option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" data-price="{{ $vehicle->prix_jour }}" data-caution="{{ $vehicle->caution }}"
                        @selected(old('vehicle_id', $contract->vehicle_id ?? '') == $vehicle->id)>
                    {{ $vehicle->marque }} {{ $vehicle->modele }} - {{ $vehicle->immatriculation }}
                </option>
            @endforeach
        </select>
        @error('vehicle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Tarif / jour (DH)</label>
        <input type="number" step="0.01" id="tarif_jour" name="tarif_jour" value="{{ old('tarif_jour', $contract->tarif_jour ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Caution (DH)</label>
        <input type="number" step="0.01" id="caution" name="caution" value="{{ old('caution', $contract->caution ?? '') }}" class="form-control">
    </div>
</div>

{{-- =================== PÉRIODE =================== --}}
<div class="section-title"><i class="bi bi-calendar-range"></i> Période &amp; kilométrage</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Date départ</label>
        <input type="date" id="date_depart" name="date_depart" value="{{ old('date_depart', isset($contract) ? $contract->date_depart?->format('Y-m-d') : '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Heure départ</label>
        <input type="time" name="heure_depart" value="{{ old('heure_depart', isset($contract) ? substr($contract->heure_depart ?? '', 0, 5) : '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Date retour</label>
        <input type="date" id="date_retour" name="date_retour" value="{{ old('date_retour', isset($contract) ? $contract->date_retour?->format('Y-m-d') : '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Heure retour</label>
        <input type="time" name="heure_retour" value="{{ old('heure_retour', isset($contract) ? substr($contract->heure_retour ?? '', 0, 5) : '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Km départ</label>
        <input type="number" name="km_depart" class="form-control" value="{{ old('km_depart', $contract->km_depart ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Km retour</label>
        <input type="number" name="km_retour" class="form-control" value="{{ old('km_retour', $contract->km_retour ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Nombre de jours</label>
        <input type="number" id="nombre_jours" name="nombre_jours" readonly class="form-control" style="background:#f6f7f9" value="{{ old('nombre_jours', $contract->nombre_jours ?? 1) }}">
    </div>
</div>

{{-- =================== FRAIS =================== --}}
<div class="section-title"><i class="bi bi-receipt"></i> Frais &amp; règlement</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Avance (DH)</label>
        <input type="number" step="0.01" id="avance" name="avance" class="form-control" value="{{ old('avance', $contract->avance ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Total HT</label>
        <input readonly id="total_ht" name="total_ht" class="form-control" style="background:#f6f7f9" value="{{ old('total_ht', $contract->total_ht ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">TVA (20%)</label>
        <input readonly id="tva" name="tva" class="form-control" style="background:#f6f7f9" value="{{ old('tva', $contract->tva ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Total TTC</label>
        <input readonly id="total_ttc" name="total_ttc" class="form-control" style="background:#eef0fe;font-weight:700" value="{{ old('total_ttc', $contract->total_ttc ?? 0) }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Mode de paiement</label>
        <select name="mode_paiement" class="form-select">
            @foreach($modes as $m)
                <option value="{{ $m }}" @selected($curMode == $m)>{{ $m }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select">
            @foreach(App\Enums\ContractStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(old('statut', isset($contract) ? $contract->statut->value : 'en_attente') == $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Observation</label>
        <textarea name="observation" rows="1" class="form-control">{{ old('observation', $contract->observation ?? '') }}</textarea>
    </div>
</div>

<div class="form-footer">
    <a href="{{ route('contracts.index') }}" class="btn-soft">Annuler</a>
    <button type="submit" class="btn-brand"><i class="bi bi-check-lg"></i> {{ isset($contract) ? 'Mettre à jour' : 'Créer le contrat' }}</button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const vehicle = document.getElementById('vehicle_id');
    const tarif   = document.getElementById('tarif_jour');
    const caution = document.getElementById('caution');
    const depart  = document.getElementById('date_depart');
    const retour  = document.getElementById('date_retour');
    const jours   = document.getElementById('nombre_jours');
    const ht      = document.getElementById('total_ht');
    const tva     = document.getElementById('tva');
    const ttc     = document.getElementById('total_ttc');

function calcul() {
    if (depart.value && retour.value) {
        let d1 = new Date(depart.value);
        let d2 = new Date(retour.value);
        let diff = Math.round((d2 - d1) / (1000 * 60 * 60 * 24));
        diff = diff <= 0 ? 1 : diff;
        jours.value = diff;
        let total = diff * parseFloat(tarif.value || 0);
        ht.value  = total.toFixed(2);
        tva.value = "0.00";
        ttc.value = total.toFixed(2);
    }
}

    vehicle.addEventListener('change', function () {
        if (this.selectedOptions[0]) {
            tarif.value   = this.selectedOptions[0].dataset.price   || tarif.value;
            caution.value = this.selectedOptions[0].dataset.caution || caution.value;
        }
        calcul();
    });
    depart.addEventListener('change', calcul);
    retour.addEventListener('change', calcul);
    tarif.addEventListener('keyup', calcul);
});
</script>
@endpush
