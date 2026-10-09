@php($isEdit = isset($infraction) && $infraction->exists)
@php($selectedVehicle = $vehicles->firstWhere('id', old('vehicle_id', $infraction->vehicle_id ?? null)))

<div class="row g-3">
    <div class="col-12 col-lg-6">
        <div class="card2 h-100">
            <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
                <div class="fw-semibold"><i class="bi bi-car-front me-1"></i> Vehicule</div>
                <div class="mut" style="font-size:13px">Selectionnez un vehicule de votre agence.</div>
            </div>
            <div style="padding:18px">
                <label for="vehicle_id" class="form-label">Immatriculation <span class="text-danger">*</span></label>
                <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                    <option value="">Selectionner une immatriculation</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" data-prix-jour="{{ $vehicle->prix_jour }}" @selected(old('vehicle_id', $infraction->vehicle_id ?? '') == $vehicle->id)>
                            {{ $vehicle->immatriculation }} — {{ $vehicle->marque }} {{ $vehicle->modele }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card2 h-100">
            <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
                <div class="fw-semibold"><i class="bi bi-person me-1"></i> Client</div>
                <div class="mut" style="font-size:13px">Selectionnez un client pour remplir automatiquement ses informations.</div>
            </div>
            <div style="padding:18px">
                <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                    <option value="">Selectionner un client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}"
                            data-nom="{{ $client->nom }}"
                            data-prenom="{{ $client->prenom }}"
                            data-cin="{{ $client->cin }}"
                            data-adresse="{{ $client->adresse }}"
                            data-ville="{{ $client->ville }}"
                            data-code-postal="{{ $client->code_postal }}"
                            @selected(old('client_id', $infraction->client_id ?? '') == $client->id)>
                            {{ $client->nom }} {{ $client->prenom }} — {{ $client->cin }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card2">
            <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
                <div class="fw-semibold"><i class="bi bi-calendar-range me-1"></i> Période de location</div>
                <div class="mut" style="font-size:13px">Saisissez manuellement les dates et heures de la location.</div>
            </div>
            <div style="padding:18px" class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="date_depart" class="form-label">Date de départ</label>
                    <input type="date" name="date_depart" id="date_depart" value="{{ old('date_depart', isset($infraction) && $infraction->date_depart ? $infraction->date_depart->format('Y-m-d') : '') }}" class="form-control @error('date_depart') is-invalid @enderror">
                    @error('date_depart')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label for="heure_depart" class="form-label">Heure de départ</label>
                    <input type="time" name="heure_depart" id="heure_depart" value="{{ old('heure_depart', isset($infraction) && $infraction->heure_depart ? \Illuminate\Support\Str::substr($infraction->heure_depart, 0, 5) : '') }}" class="form-control @error('heure_depart') is-invalid @enderror">
                    @error('heure_depart')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label for="date_retour" class="form-label">Date de retour</label>
                    <input type="date" name="date_retour" id="date_retour" value="{{ old('date_retour', isset($infraction) && $infraction->date_retour ? $infraction->date_retour->format('Y-m-d') : '') }}" class="form-control @error('date_retour') is-invalid @enderror">
                    @error('date_retour')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label for="heure_retour" class="form-label">Heure de retour</label>
                    <input type="time" name="heure_retour" id="heure_retour" value="{{ old('heure_retour', isset($infraction) && $infraction->heure_retour ? \Illuminate\Support\Str::substr($infraction->heure_retour, 0, 5) : '') }}" class="form-control @error('heure_retour') is-invalid @enderror">
                    @error('heure_retour')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card2">
            <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
                <div class="fw-semibold"><i class="bi bi-cash-coin me-1"></i> Tarif et avance</div>
            </div>
            <div style="padding:18px" class="row g-3">
                <div class="col-md-6">
                    <label for="tarif_jour" class="form-label">Prix par jour (DH)</label>
                    <input type="number" step="0.01" min="0" name="tarif_jour" id="tarif_jour"
                        value="{{ old('tarif_jour', $infraction->tarif_jour ?? $selectedVehicle?->prix_jour ?? '') }}"
                        class="form-control @error('tarif_jour') is-invalid @enderror" required>
                    @error('tarif_jour')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="avance" class="form-label">Avance (DH)</label>
                    <input type="number" step="0.01" min="0" name="avance" id="avance"
                        value="{{ old('avance', $infraction->avance ?? 0) }}"
                        class="form-control @error('avance') is-invalid @enderror" required>
                    @error('avance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <div class="p-3 rounded" style="background:var(--bg,#f8fafc)">
                        <div class="d-flex justify-content-between"><span>Durée</span><strong id="calculated_days">—</strong></div>
                        <div class="d-flex justify-content-between mt-2"><span>Total location</span><strong id="calculated_total">0,00 DH</strong></div>
                        <div class="d-flex justify-content-between mt-2"><span>Avance</span><strong id="calculated_advance">0,00 DH</strong></div>
                        <div class="d-flex justify-content-between mt-2"><span>Reste après avance</span><strong id="calculated_balance">0,00 DH</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card2">
            <div style="padding:16px 18px;border-bottom:1px solid var(--line)">
                <div class="fw-semibold"><i class="bi bi-card-text me-1"></i> Informations du client</div>
                <div class="mut" style="font-size:13px">Lecture seule : les donnees sont copiees depuis la fiche client selectionnee.</div>
            </div>
            <div style="padding:18px" class="row g-3">
                <div class="col-md-6"><label class="form-label">Nom</label><input id="client_nom" class="form-control" readonly></div>
                <div class="col-md-6"><label class="form-label">Prenom</label><input id="client_prenom" class="form-control" readonly></div>
                <div class="col-md-6"><label class="form-label">CIN</label><input id="client_cin" class="form-control" readonly></div>
                <div class="col-md-6"><label class="form-label">Code postal</label><input id="client_code_postal" class="form-control" readonly></div>
                <div class="col-md-6"><label class="form-label">Ville</label><input id="client_ville" class="form-control" readonly></div>
                <div class="col-md-6"><label class="form-label">Adresse</label><input id="client_adresse" class="form-control" readonly></div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('infractions.index') }}" class="btn btn-light">Annuler</a>
    <button type="submit" class="btn-brand"><i class="bi bi-check-lg"></i> {{ $isEdit ? 'Enregistrer les modifications' : 'Creer l’infraction' }}</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('client_id');
    const fields = {
        nom: 'client_nom', prenom: 'client_prenom', cin: 'client_cin',
        adresse: 'client_adresse', ville: 'client_ville', codePostal: 'client_code_postal',
    };

    const vehicleSelect = document.getElementById('vehicle_id');
    vehicleSelect.addEventListener('change', () => {
        const option = vehicleSelect.options[vehicleSelect.selectedIndex];
        if (option?.dataset.prixJour) {
            document.getElementById('tarif_jour').value = option.dataset.prixJour;
        }
    });

    const money = value => `${new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value)} DH`;
    const updateTotal = () => {
        const start = document.getElementById('date_depart').value;
        const end = document.getElementById('date_retour').value;
        let days = 0;
        if (start && end) {
            const [sy, sm, sd] = start.split('-').map(Number);
            const [ey, em, ed] = end.split('-').map(Number);
            days = Math.max(1, Math.round((Date.UTC(ey, em - 1, ed) - Date.UTC(sy, sm - 1, sd)) / 86400000));
        }
        const rate = Number(document.getElementById('tarif_jour').value) || 0;
        const advance = Number(document.getElementById('avance').value) || 0;
        const total = days * rate;
        document.getElementById('calculated_days').textContent = days ? `${days} jour(s)` : '—';
        document.getElementById('calculated_total').textContent = money(total);
        document.getElementById('calculated_advance').textContent = money(advance);
        document.getElementById('calculated_balance').textContent = money(Math.max(0, total - advance));
    };
    ['date_depart', 'date_retour', 'tarif_jour', 'avance'].forEach(id => {
        document.getElementById(id).addEventListener('input', updateTotal);
    });
    updateTotal();

    const fillClient = () => {
        const option = select.options[select.selectedIndex];
        Object.entries(fields).forEach(([dataName, inputId]) => {
            document.getElementById(inputId).value = option?.dataset[dataName] ?? '';
        });
    };

    select.addEventListener('change', fillClient);
    fillClient();
});
</script>
