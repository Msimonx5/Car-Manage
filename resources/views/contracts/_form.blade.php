<div class="row">

    <!-- =========================
        CLIENT
    ========================== -->

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Client *
        </label>

        <select
            name="client_id"
            id="client_id"
            class="form-select @error('client_id') is-invalid @enderror">

            <option value="">
                Sélectionner...
            </option>

            @foreach($clients as $client)

                <option
                    value="{{ $client->id }}"
                    @selected(old('client_id',$contract->client_id ?? '')==$client->id)>

                    {{ $client->nom }} {{ $client->prenom }}

                </option>

            @endforeach

        </select>

        @error('client_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Deuxième conducteur

        </label>

        <select
            name="second_driver_id"
            class="form-select">

            <option value="">
                Aucun
            </option>

            @foreach($clients as $client)

                <option
                    value="{{ $client->id }}"
                    @selected(old('second_driver_id',$contract->second_driver_id ?? '')==$client->id)>

                    {{ $client->nom }} {{ $client->prenom }}

                </option>

            @endforeach

        </select>

    </div>

</div>

<hr>

<div class="row">

    <!-- =========================
        VEHICULE
    ========================== -->

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Véhicule *

        </label>

        <select
            name="vehicle_id"
            id="vehicle_id"
            class="form-select">

            <option value="">
                Sélectionner...

            </option>

            @foreach($vehicles as $vehicle)

                <option
                    value="{{ $vehicle->id }}"
                    data-price="{{ $vehicle->prix_jour }}"
                    data-caution="{{ $vehicle->caution }}"
                    @selected(old('vehicle_id',$contract->vehicle_id ?? '')==$vehicle->id)>

                    {{ $vehicle->marque }}
                    {{ $vehicle->modele }}
                    -
                    {{ $vehicle->immatriculation }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-3">

        <label class="form-label">

            Tarif / jour

        </label>

        <input
            type="number"
            step="0.01"
            id="tarif_jour"
            name="tarif_jour"
            value="{{ old('tarif_jour',$contract->tarif_jour ?? '') }}"
            class="form-control">

    </div>

    <div class="col-md-3">

        <label class="form-label">

            Caution

        </label>

        <input
            type="number"
            step="0.01"
            id="caution"
            name="caution"
            value="{{ old('caution',$contract->caution ?? '') }}"
            class="form-control">

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-3">

        <label>

            Date départ

        </label>

        <input
            type="date"
            id="date_depart"
            name="date_depart"
            value="{{ old('date_depart',isset($contract)?$contract->date_depart?->format('Y-m-d'):'') }}"
            class="form-control">

    </div>

    <div class="col-md-3">

        <label>

            Heure départ

        </label>

        <input
            type="time"
            name="heure_depart"
            value="{{ old('heure_depart',$contract->heure_depart ?? '') }}"
            class="form-control">

    </div>

    <div class="col-md-3">

        <label>

            Date retour

        </label>

        <input
            type="date"
            id="date_retour"
            name="date_retour"
            value="{{ old('date_retour',isset($contract)?$contract->date_retour?->format('Y-m-d'):'') }}"
            class="form-control">

    </div>

    <div class="col-md-3">

        <label>

            Heure retour

        </label>

        <input
            type="time"
            name="heure_retour"
            value="{{ old('heure_retour',$contract->heure_retour ?? '') }}"
            class="form-control">

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-3">

        <label>

            Km départ

        </label>

        <input
            type="number"
            name="km_depart"
            class="form-control"
            value="{{ old('km_depart',$contract->km_depart ?? '') }}">

    </div>

    <div class="col-md-3">

        <label>

            Km retour

        </label>

        <input
            type="number"
            name="km_retour"
            class="form-control"
            value="{{ old('km_retour',$contract->km_retour ?? '') }}">

    </div>

    <div class="col-md-3">

        <label>

            Avance

        </label>

        <input
            type="number"
            step="0.01"
            id="avance"
            name="avance"
            class="form-control"
            value="{{ old('avance',$contract->avance ?? 0) }}">

    </div>

    <div class="col-md-3">

        <label>

            Nombre de jours

        </label>

        <input
            type="number"
            id="nombre_jours"
            name="nombre_jours"
            readonly
            class="form-control"
            value="{{ old('nombre_jours',$contract->nombre_jours ?? 1) }}">

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-4">

        <label>

            Total HT

        </label>

        <input
            readonly
            id="total_ht"
            name="total_ht"
            class="form-control"
            value="{{ old('total_ht',$contract->total_ht ?? 0) }}">

    </div>

    <div class="col-md-4">

        <label>

            TVA (20%)

        </label>

        <input
            readonly
            id="tva"
            name="tva"
            class="form-control"
            value="{{ old('tva',$contract->tva ?? 0) }}">

    </div>

    <div class="col-md-4">

        <label>

            Total TTC

        </label>

        <input
            readonly
            id="total_ttc"
            name="total_ttc"
            class="form-control"
            value="{{ old('total_ttc',$contract->total_ttc ?? 0) }}">

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-6">

        <label>

            Mode de paiement

        </label>

        <select
            name="mode_paiement"
            class="form-select">

            <option value="Espèces">Espèces</option>

            <option value="Carte bancaire">Carte bancaire</option>

            <option value="Virement">Virement</option>

            <option value="Chèque">Chèque</option>

        </select>

    </div>

    <div class="col-md-6">

        <label>

            Statut

        </label>

        <select
            name="statut"
            class="form-select">

            @foreach(App\Enums\ContractStatus::cases() as $status)

                <option
                    value="{{ $status->value }}"
                    @selected(old('statut',$contract->statut->value ?? 'en_attente')==$status->value)>

                    {{ $status->label() }}

                </option>

            @endforeach

        </select>

    </div>

</div>

<div class="mt-3">

    <label>

        Observation

    </label>

    <textarea
        name="observation"
        rows="4"
        class="form-control">{{ old('observation',$contract->observation ?? '') }}</textarea>

</div>

<hr>

<div class="text-end">

    <button class="btn btn-success">

        {{ isset($contract) ? 'Mettre à jour' : 'Créer le contrat' }}

    </button>

    <a
        href="{{ route('contracts.index') }}"
        class="btn btn-secondary">

        Retour

    </a>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const vehicle = document.getElementById('vehicle_id');
    const tarif = document.getElementById('tarif_jour');
    const caution = document.getElementById('caution');

    const depart = document.getElementById('date_depart');
    const retour = document.getElementById('date_retour');

    const jours = document.getElementById('nombre_jours');
    const ht = document.getElementById('total_ht');
    const tva = document.getElementById('tva');
    const ttc = document.getElementById('total_ttc');

    function calcul() {

        if(depart.value && retour.value){

            let d1 = new Date(depart.value);
            let d2 = new Date(retour.value);

            let diff = Math.ceil((d2-d1)/(1000*60*60*24))+1;

            diff = diff <=0 ? 1 : diff;

            jours.value = diff;

            let total = diff * parseFloat(tarif.value || 0);

            ht.value = total.toFixed(2);

            tva.value = (total*0.20).toFixed(2);

            ttc.value = (total*1.20).toFixed(2);

        }

    }

    vehicle.addEventListener('change',function(){

        tarif.value=this.selectedOptions[0].dataset.price;

        caution.value=this.selectedOptions[0].dataset.caution;

        calcul();

    });

    depart.addEventListener('change',calcul);

    retour.addEventListener('change',calcul);

    tarif.addEventListener('keyup',calcul);

});
</script>
@endpush