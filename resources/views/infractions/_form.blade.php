{{-- resources/views/infractions/_form.blade.php --}}

@php
$isEdit = isset($infraction) && $infraction->exists;
@endphp

<div class="row g-3">

```
{{-- Contrat --}}
<div class="col-12">
    <div class="card2">

        <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
            <div class="fw-semibold">
                <i class="bi bi-file-earmark-text me-1"></i>
                Contrat de location
            </div>

            <div class="mut" style="font-size:13px">
                Sélectionnez le contrat concerné par l'infraction.
            </div>
        </div>

        <div style="padding:18px">

            <div class="row g-3">

                <div class="col-md-8">

                    <label for="contract_id" class="form-label">
                        Contrat <span class="text-danger">*</span>
                    </label>

                    <select
                        name="contract_id"
                        id="contract_id"
                        class="form-select @error('contract_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Sélectionner un contrat
                        </option>

                        @foreach($contracts as $contract)

                            <option
                                value="{{ $contract->id }}"
                                data-client-id="{{ $contract->client?->id }}"
                                data-client-name="{{ $contract->client?->nom }} {{ $contract->client?->prenom }}"
                                data-client-cin="{{ $contract->client?->cin }}"
                                data-client-permis="{{ $contract->client?->numero_permis }}"
                                data-client-address="{{ $contract->client?->adresse }}"
                                data-client-ville="{{ $contract->client?->ville }}"
                                data-client-code-postal="{{ $contract->client?->code_postal }}"
                                data-client-phone="{{ $contract->client?->telephone }}"
                                data-client-email="{{ $contract->client?->email }}"
                                data-vehicle-id="{{ $contract->vehicle?->id }}"
                                data-vehicle-name="{{ $contract->vehicle?->marque }} {{ $contract->vehicle?->modele }}"
                                data-vehicle-immatriculation="{{ $contract->vehicle?->immatriculation }}"
                                data-contract-number="{{ $contract->numero }}"
                                data-date-depart="{{ $contract->date_depart?->format('Y-m-d') }}"
                                data-heure-depart="{{ $contract->heure_depart }}"
                                data-date-retour="{{ $contract->date_retour?->format('Y-m-d') }}"
                                data-heure-retour="{{ $contract->heure_retour }}"
                                @selected(old('contract_id', $infraction->contract_id ?? '') == $contract->id)
                            >

                                {{ $contract->numero }}
                                —
                                {{ $contract->client?->nom }}
                                {{ $contract->client?->prenom }}
                                —
                                {{ $contract->vehicle?->immatriculation }}

                            </option>

                        @endforeach

                    </select>

                    @error('contract_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>
</div>


{{-- Informations client --}}
<div class="col-12 col-lg-6">

    <div class="card2 h-100">

        <div style="padding:16px 18px;border-bottom:1px solid var(--line)">

            <div class="fw-semibold">
                <i class="bi bi-person me-1"></i>
                Informations du client
            </div>

            <div class="mut" style="font-size:13px">
                Informations récupérées automatiquement depuis le contrat.
            </div>

        </div>

        <div style="padding:18px">

            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label">
                        Nom
                    </label>

                    <input
                        type="text"
                        id="client_nom"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Prénom
                    </label>

                    <input
                        type="text"
                        id="client_prenom"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        C.N.I.E
                    </label>

                    <input
                        type="text"
                        id="client_cin"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        N° permis
                    </label>

                    <input
                        type="text"
                        id="client_permis"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-12">

                    <label class="form-label">
                        Adresse
                    </label>

                    <input
                        type="text"
                        id="client_adresse"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-5">

                    <label class="form-label">
                        Ville
                    </label>

                    <input
                        type="text"
                        id="client_ville"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                        Code postal
                    </label>

                    <input
                        type="text"
                        id="client_code_postal"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        GSM
                    </label>

                    <input
                        type="text"
                        id="client_telephone"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-12">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="text"
                        id="client_email"
                        class="form-control"
                        readonly
                    >

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Informations véhicule --}}
<div class="col-12 col-lg-6">

    <div class="card2 h-100">

        <div style="padding:16px 18px;border-bottom:1px solid var(--line)">

            <div class="fw-semibold">
                <i class="bi bi-car-front me-1"></i>
                Informations du véhicule
            </div>

            <div class="mut" style="font-size:13px">
                Informations récupérées automatiquement depuis le contrat.
            </div>

        </div>

        <div style="padding:18px">

            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label">
                        Marque
                    </label>

                    <input
                        type="text"
                        id="vehicle_marque"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Modèle
                    </label>

                    <input
                        type="text"
                        id="vehicle_modele"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-12">

                    <label class="form-label">
                        Immatriculation
                    </label>

                    <input
                        type="text"
                        id="vehicle_immatriculation"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-12">

                    <label class="form-label">
                        N° contrat
                    </label>

                    <input
                        type="text"
                        id="numero_contrat"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Départ
                    </label>

                    <input
                        type="text"
                        id="contrat_depart"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Retour
                    </label>

                    <input
                        type="text"
                        id="contrat_retour"
                        class="form-control"
                        readonly
                    >

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Informations infraction --}}
<div class="col-12">

    <div class="card2">

        <div style="padding:16px 18px;border-bottom:1px solid var(--line)">

        </div>

    </div>

</div>

</div>

{{-- Actions --}}

<div class="d-flex justify-content-end gap-2 mt-4">

```
<a
    href="{{ route('infractions.index') }}"
    class="btn btn-light"
>
    Annuler
</a>

<button
    type="submit"
    class="btn-brand"
>
    <i class="bi bi-check-lg"></i>

    {{ $isEdit ? 'Enregistrer les modifications' : 'Créer l’infraction' }}

</button>
```

</div>

{{-- Auto-fill depuis le contrat --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const contractSelect = document.getElementById('contract_id');

    function fillContractData() {

        const option = contractSelect.options[
            contractSelect.selectedIndex
        ];

        if (!option || !option.value) {

            clearFields();

            return;

        }

        // Client

        const clientName =
            option.dataset.clientName || '';

        const nameParts =
            clientName.trim().split(/\s+/);

        document.getElementById('client_nom').value =
            option.dataset.clientName
                ? nameParts.shift() || ''
                : '';

        document.getElementById('client_prenom').value =
            nameParts.join(' ');

        document.getElementById('client_cin').value =
            option.dataset.clientCin || '';

        document.getElementById('client_permis').value =
            option.dataset.clientPermis || '';

        document.getElementById('client_adresse').value =
            option.dataset.clientAddress || '';

        document.getElementById('client_ville').value =
            option.dataset.clientVille || '';

        document.getElementById('client_code_postal').value =
            option.dataset.clientCodePostal || '';

        document.getElementById('client_telephone').value =
            option.dataset.clientPhone || '';

        document.getElementById('client_email').value =
            option.dataset.clientEmail || '';


        // Véhicule

        const vehicleName =
            option.dataset.vehicleName || '';

        const vehicleParts =
            vehicleName.trim().split(/\s+/);

        document.getElementById('vehicle_marque').value =
            vehicleParts.shift() || '';

        document.getElementById('vehicle_modele').value =
            vehicleParts.join(' ');

        document.getElementById('vehicle_immatriculation').value =
            option.dataset.vehicleImmatriculation || '';


        // Contrat

        document.getElementById('numero_contrat').value =
            option.dataset.contractNumber || '';

        document.getElementById('contrat_depart').value =
            formatDateTime(
                option.dataset.dateDepart,
                option.dataset.heureDepart
            );

        document.getElementById('contrat_retour').value =
            formatDateTime(
                option.dataset.dateRetour,
                option.dataset.heureRetour
            );

    }


    function formatDateTime(date, time) {

        if (!date) {
            return '';
        }

        const parts = date.split('-');

        let result =
            parts[2] + '/' +
            parts[1] + '/' +
            parts[0];

        if (time) {

            result +=
                ' à ' +
                time.substring(0, 5);

        }

        return result;

    }


    function clearFields() {

        const fields = [
            'client_nom',
            'client_prenom',
            'client_cin',
            'client_permis',
            'client_adresse',
            'client_ville',
            'client_code_postal',
            'client_telephone',
            'client_email',
            'vehicle_marque',
            'vehicle_modele',
            'vehicle_immatriculation',
            'numero_contrat',
            'contrat_depart',
            'contrat_retour'
        ];

        fields.forEach(function (id) {

            const element =
                document.getElementById(id);

            if (element) {
                element.value = '';
            }

        });

    }


    contractSelect.addEventListener(
        'change',
        fillContractData
    );

    // Remplissage automatique en création et modification
    fillContractData();

});

</script>
