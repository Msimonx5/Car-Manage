<div class="row">

    {{-- Informations générales --}}

    <div class="col-md-4 mb-3">
        <label class="form-label">Marque</label>

        <input
            type="text"
            name="marque"
            class="form-control @error('marque') is-invalid @enderror"
            value="{{ old('marque',$vehicle->marque ?? '') }}">

        @error('marque')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Modèle</label>

        <input
            type="text"
            name="modele"
            class="form-control"
            value="{{ old('modele',$vehicle->modele ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Année</label>

        <input
            type="number"
            name="annee"
            class="form-control"
            value="{{ old('annee',$vehicle->annee ?? '') }}">
    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-4 mb-3">

        <label class="form-label">

            Immatriculation

        </label>

        <input
            type="text"
            name="immatriculation"
            class="form-control"
            value="{{ old('immatriculation',$vehicle->immatriculation ?? '') }}">

    </div>

    <div class="col-md-4 mb-3">

        <label class="form-label">

            Châssis

        </label>

        <input
            type="text"
            name="numero_chassis"
            class="form-control"
            value="{{ old('numero_chassis',$vehicle->numero_chassis ?? '') }}">

    </div>

    <div class="col-md-4 mb-3">

        <label class="form-label">

            Numéro moteur

        </label>

        <input
            type="text"
            name="numero_moteur"
            class="form-control"
            value="{{ old('numero_moteur',$vehicle->numero_moteur ?? '') }}">

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-3">

        <label>Carburant</label>

        <select
            name="carburant"
            class="form-select">

            <option value="Essence">Essence</option>

            <option value="Diesel">Diesel</option>

            <option value="Hybride">Hybride</option>

            <option value="Electrique">Électrique</option>

        </select>

    </div>

    <div class="col-md-3">

        <label>Boîte</label>

        <select
            name="boite_vitesse"
            class="form-select">

            <option value="Manuelle">

                Manuelle

            </option>

            <option value="Automatique">

                Automatique

            </option>

        </select>

    </div>

    <div class="col-md-3">

        <label>Places</label>

        <input
            type="number"
            name="nombre_places"
            class="form-control"
            value="{{ old('nombre_places',$vehicle->nombre_places ?? 5) }}">

    </div>

    <div class="col-md-3">

        <label>Couleur</label>

        <input
            type="text"
            name="couleur"
            class="form-control"
            value="{{ old('couleur',$vehicle->couleur ?? '') }}">

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-3">

        <label>Prix / jour</label>

        <input
            type="number"
            step="0.01"
            name="prix_jour"
            class="form-control"
            value="{{ old('prix_jour',$vehicle->prix_jour ?? '') }}">

    </div>

    <div class="col-md-3">

        <label>Caution</label>

        <input
            type="number"
            step="0.01"
            name="caution"
            class="form-control"
            value="{{ old('caution',$vehicle->caution ?? '') }}">

    </div>

    <div class="col-md-3">

        <label>Kilométrage</label>

        <input
            type="number"
            name="kilometrage"
            class="form-control"
            value="{{ old('kilometrage',$vehicle->kilometrage ?? 0) }}">

    </div>

    <div class="col-md-3">

        <label>Statut</label>

        <select
            name="statut"
            class="form-select">

            @foreach(\App\Enums\VehicleStatus::cases() as $status)

                <option
                    value="{{ $status->value }}"
                    @selected(old('statut',$vehicle->statut->value ?? 'disponible')==$status->value)>

                    {{ $status->label() }}

                </option>

            @endforeach

        </select>

    </div>

</div>

<hr>

<h5 class="mb-3">

Suivi de la maintenance

</h5>

<div class="row">

    <div class="col-md-4">

        <label>Dernière vidange (Km)</label>

        <input
            type="number"
            name="derniere_vidange_km"
            class="form-control"
            value="{{ old('derniere_vidange_km',$vehicle->derniere_vidange_km ?? '') }}">

    </div>

    <div class="col-md-4">

        <label>Prochaine vidange (Km)</label>

        <input
            type="number"
            name="prochaine_vidange_km"
            class="form-control"
            value="{{ old('prochaine_vidange_km',$vehicle->prochaine_vidange_km ?? '') }}">

    </div>

    <div class="col-md-4">

        <label>Date dernière vidange</label>

        <input
            type="date"
            name="derniere_vidange_date"
            class="form-control"
            value="{{ old('derniere_vidange_date',isset($vehicle)?optional($vehicle->derniere_vidange_date)->format('Y-m-d'):'') }}">
    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-6">

        <label>Expiration Assurance</label>

        <input
            type="date"
            name="assurance_expiration"
            class="form-control"
            value="{{ old('assurance_expiration',isset($vehicle)?optional($vehicle->assurance_expiration)->format('Y-m-d'):'') }}">

    </div>

    <div class="col-md-6">

        <label>Visite Technique</label>

        <input
            type="date"
            name="visite_technique"
            class="form-control"
            value="{{ old('visite_technique',isset($vehicle)?optional($vehicle->visite_technique)->format('Y-m-d'):'') }}">

    </div>

</div>

<hr>

<div class="mb-3">

    <label>Observation</label>

    <textarea
        name="observation"
        rows="4"
        class="form-control">{{ old('observation',$vehicle->observation ?? '') }}</textarea>

</div>

<button
    class="btn btn-primary">

    {{ isset($vehicle) ? 'Mettre à jour' : 'Enregistrer' }}

</button>

<a
    href="{{ route('vehicles.index') }}"
    class="btn btn-secondary">

    Retour

</a>