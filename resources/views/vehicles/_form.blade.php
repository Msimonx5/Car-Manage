@php
    $carburants = ['Essence', 'Diesel', 'Hybride', 'Electrique'];
    $boites = ['Manuelle', 'Automatique'];
    $curCarburant = old('carburant', $vehicle->carburant ?? 'Essence');
    $curBoite = old('boite_vitesse', $vehicle->boite_vitesse ?? 'Manuelle');
@endphp

{{-- =================== INFORMATIONS GÉNÉRALES =================== --}}
<div class="section-title"><i class="bi bi-car-front"></i> Informations générales</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Marque <span class="req">*</span></label>
        <input type="text" name="marque" class="form-control @error('marque') is-invalid @enderror" value="{{ old('marque', $vehicle->marque ?? '') }}">
        @error('marque')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Modèle <span class="req">*</span></label>
        <input type="text" name="modele" class="form-control @error('modele') is-invalid @enderror" value="{{ old('modele', $vehicle->modele ?? '') }}">
        @error('modele')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Année</label>
        <input type="number" name="annee" class="form-control @error('annee') is-invalid @enderror" value="{{ old('annee', $vehicle->annee ?? '') }}">
        @error('annee')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Carburant</label>
        <select name="carburant" class="form-select">
            @foreach($carburants as $c)
                <option value="{{ $c }}" @selected($curCarburant == $c)>{{ $c === 'Electrique' ? 'Électrique' : $c }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Boîte</label>
        <select name="boite_vitesse" class="form-select">
            @foreach($boites as $b)
                <option value="{{ $b }}" @selected($curBoite == $b)>{{ $b }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Places</label>
        <input type="number" name="nombre_places" class="form-control" value="{{ old('nombre_places', $vehicle->nombre_places ?? 5) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Couleur</label>
        <input type="text" name="couleur" class="form-control" value="{{ old('couleur', $vehicle->couleur ?? '') }}">
    </div>
</div>

{{-- =================== IDENTIFICATION =================== --}}
<div class="section-title"><i class="bi bi-upc-scan"></i> Identification</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Immatriculation <span class="req">*</span></label>
        <input type="text" name="immatriculation" class="form-control @error('immatriculation') is-invalid @enderror" value="{{ old('immatriculation', $vehicle->immatriculation ?? '') }}">
        @error('immatriculation')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">N° Châssis</label>
        <input type="text" name="numero_chassis" class="form-control" value="{{ old('numero_chassis', $vehicle->numero_chassis ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">N° Moteur</label>
        <input type="text" name="numero_moteur" class="form-control" value="{{ old('numero_moteur', $vehicle->numero_moteur ?? '') }}">
    </div>
</div>

{{-- =================== LOCATION & ÉTAT =================== --}}
<div class="section-title"><i class="bi bi-cash-coin"></i> Location &amp; état</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Prix / jour (DH)</label>
        <input type="number" step="0.01" name="prix_jour" class="form-control @error('prix_jour') is-invalid @enderror" value="{{ old('prix_jour', $vehicle->prix_jour ?? '') }}">
        @error('prix_jour')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Caution (DH)</label>
        <input type="number" step="0.01" name="caution" class="form-control" value="{{ old('caution', $vehicle->caution ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Kilométrage</label>
        <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage', $vehicle->kilometrage ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select">
            @foreach(\App\Enums\VehicleStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(old('statut', isset($vehicle) ? $vehicle->statut->value : 'disponible') == $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- =================== MAINTENANCE =================== --}}
<div class="section-title"><i class="bi bi-tools"></i> Suivi de la maintenance</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Dernière vidange (Km)</label>
        <input type="number" name="derniere_vidange_km" class="form-control" value="{{ old('derniere_vidange_km', $vehicle->derniere_vidange_km ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Prochaine vidange (Km)</label>
        <input type="number" name="prochaine_vidange_km" class="form-control" value="{{ old('prochaine_vidange_km', $vehicle->prochaine_vidange_km ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date dernière vidange</label>
        <input type="date" name="derniere_vidange_date" class="form-control" value="{{ old('derniere_vidange_date', isset($vehicle) ? optional($vehicle->derniere_vidange_date)->format('Y-m-d') : '') }}">
    </div>
    <div class="col-12 mt-2 mb-2"><strong>Filtres</strong><div class="text-muted small">Renseignez la date du dernier remplacement. Une date vide signifie que le changement n’est pas enregistré.</div></div>
    @foreach([
        'filtre_air_date' => 'Filtre à air',
        'filtre_huile_date' => 'Filtre à huile',
        'filtre_carburant_date' => 'Filtre à carburant',
        'filtre_habitacle_date' => 'Chaîne de distribution',
    ] as $field => $label)
        <div class="col-md-3 mb-3">
            <label class="form-label">{{ $label }} — date de changement</label>
            <input type="date" name="{{ $field }}" class="form-control" value="{{ old($field, isset($vehicle) ? optional($vehicle->{$field})->format('Y-m-d') : '') }}">
        </div>
    @endforeach
    @foreach([
        ['date' => 'pneus_date', 'text' => 'pneus_description', 'label' => 'Pneus'],
        ['date' => 'plaquettes_frein_date', 'text' => 'plaquettes_frein_description', 'label' => 'Plaquettes de frein'],
    ] as $part)
        <div class="col-md-3 mb-3">
            <label class="form-label">{{ $part['label'] }}</label>
            <input type="text" name="{{ $part['text'] }}" class="form-control" value="{{ old($part['text'], $vehicle->{$part['text']} ?? '') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Date du dernier changement</label>
            <input type="date" name="{{ $part['date'] }}" class="form-control" value="{{ old($part['date'], isset($vehicle) ? optional($vehicle->{$part['date']})->format('Y-m-d') : '') }}">
        </div>
    @endforeach
    <div class="col-md-6 mb-3">
        <label class="form-label">Expiration assurance</label>
        <input type="date" name="assurance_expiration" class="form-control" value="{{ old('assurance_expiration', isset($vehicle) ? optional($vehicle->assurance_expiration)->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Visite technique</label>
        <input type="date" name="visite_technique" class="form-control" value="{{ old('visite_technique', isset($vehicle) ? optional($vehicle->visite_technique)->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="mb-1">
    <label class="form-label">Observation</label>
    <textarea name="observation" rows="3" class="form-control">{{ old('observation', $vehicle->observation ?? '') }}</textarea>
</div>

<div class="form-footer">
    <a href="{{ route('vehicles.index') }}" class="btn-soft">Annuler</a>
    <button type="submit" class="btn-brand"><i class="bi bi-check-lg"></i> {{ isset($vehicle) ? 'Mettre à jour' : 'Enregistrer' }}</button>
</div>
