{{-- =================== IDENTITÉ =================== --}}
<div class="section-title"><i class="bi bi-person-vcard"></i> Identité</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Type <span class="req">*</span></label>
        <select name="type" class="form-select @error('type') is-invalid @enderror">
            <option value="">Sélectionner</option>
            <option value="principal" @selected(old('type', $client->type ?? '') == 'principal')>Principal</option>
            <option value="secondaire" @selected(old('type', $client->type ?? '') == 'secondaire')>Secondaire</option>
        </select>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Nom <span class="req">*</span></label>
        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $client->nom ?? '') }}">
        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Prénom <span class="req">*</span></label>
        <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $client->prenom ?? '') }}">
        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror"
               value="{{ old('date_naissance', isset($client) && $client->date_naissance ? $client->date_naissance->format('Y-m-d') : '') }}">
        @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Lieu de naissance</label>
        <input type="text" name="lieu_naissance" class="form-control @error('lieu_naissance') is-invalid @enderror" value="{{ old('lieu_naissance', $client->lieu_naissance ?? '') }}">
        @error('lieu_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Nationalité</label>
        <input type="text" name="nationalite" class="form-control @error('nationalite') is-invalid @enderror" value="{{ old('nationalite', $client->nationalite ?? 'Marocaine') }}">
        @error('nationalite')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- =================== DOCUMENTS =================== --}}
<div class="section-title"><i class="bi bi-card-heading"></i> Documents</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">N° C.I.N <span class="req">*</span></label>
        <input type="text" name="cin" class="form-control @error('cin') is-invalid @enderror" value="{{ old('cin', $client->cin ?? '') }}">
        @error('cin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">N° Permis <span class="req">*</span></label>
        <input type="text" name="numero_permis" class="form-control @error('numero_permis') is-invalid @enderror" value="{{ old('numero_permis', $client->numero_permis ?? '') }}">
        @error('numero_permis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">N° Passeport</label>
        <input type="text" name="numero_passeport" class="form-control @error('numero_passeport') is-invalid @enderror" value="{{ old('numero_passeport', $client->numero_passeport ?? '') }}">
        @error('numero_passeport')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- =================== COORDONNÉES =================== --}}
<div class="section-title"><i class="bi bi-geo-alt"></i> Coordonnées</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Téléphone <span class="req">*</span></label>
        <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone', $client->telephone ?? '') }}">
        @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $client->email ?? '') }}">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Adresse</label>
        <textarea name="adresse" rows="2" class="form-control @error('adresse') is-invalid @enderror">{{ old('adresse', $client->adresse ?? '') }}</textarea>
        @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville', $client->ville ?? '') }}">
        @error('ville')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Code postal</label>
        <input type="text" name="code_postal" class="form-control @error('code_postal') is-invalid @enderror" value="{{ old('code_postal', $client->code_postal ?? '') }}">
        @error('code_postal')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Adresse à l'étranger</label>
        <textarea name="adresse_etranger" rows="2" class="form-control">{{ old('adresse_etranger', $client->adresse_etranger ?? '') }}</textarea>
    </div>
</div>

<div class="form-footer">
    <a href="{{ route('clients.index') }}" class="btn-soft">Annuler</a>
    <button type="submit" class="btn-brand">
        <i class="bi bi-check-lg"></i> {{ isset($client) ? 'Mettre à jour' : 'Enregistrer' }}
    </button>
</div>
