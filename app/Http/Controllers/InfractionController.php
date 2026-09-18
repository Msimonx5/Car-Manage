<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfractionRequest;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Infraction;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InfractionController extends Controller
{

    /**
     * --------------------------------------------------------------------------
     * Index
     * --------------------------------------------------------------------------
     */
    public function index(): View
    {
        $query = Infraction::with([
            'client',
            'vehicle',
            'contract',
        ]);

        /*
         * Recherche
         */
        if ($q = request('q')) {
            $query->where(function ($query) use ($q) {
                $query
                    ->where('numero_contrat', 'like', "%{$q}%")
                    ->orWhere('immatriculation', 'like', "%{$q}%")
                    ->orWhere('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('cin', 'like', "%{$q}%")
                    ->orWhere('numero_permis', 'like', "%{$q}%")
                    ->orWhere('ville', 'like', "%{$q}%");
            });
        }

        /*
         * Pagination
         */
        $infractions = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        /*
         * Statistiques
         */
        $stats = [
            'total' => Infraction::count(),
        ];

        return view(
            'infractions.index',
            compact('infractions', 'stats')
        );
    }

    /**
     * --------------------------------------------------------------------------
     * Create
     * --------------------------------------------------------------------------
     */
    public function create(): View
    {
        $usesContracts = $this->usesContracts();

        if (! $usesContracts) {
            $clients = Client::orderBy('nom')->orderBy('prenom')->get();
            $vehicles = Vehicle::orderBy('immatriculation')->get();

            return view('infractions.create', compact('usesContracts', 'clients', 'vehicles'));
        }

        $contracts = Contract::with([
            'client',
            'vehicle',
        ])
            ->latest()
            ->get();

        return view(
            'infractions.create',
            compact('contracts', 'usesContracts')
        );
    }

    /**
     * --------------------------------------------------------------------------
     * Store
     * --------------------------------------------------------------------------
     */
    public function store(
        InfractionRequest $request
    ): RedirectResponse {

        if (! $this->usesContracts()) {
            Infraction::create($this->manualInfractionData($request->validated()));

            return redirect()
                ->route('infractions.index')
                ->with('success', 'Infraction creee avec succes.');
        }

        $contract = Contract::with([
            'client',
            'vehicle',
        ])->findOrFail(
            $request->validated('contract_id')
        );

        $client = $contract->client;
        $vehicle = $contract->vehicle;

        /*
         * Vérification du client
         */
        if (!$client) {
            return back()
                ->withInput()
                ->withErrors([
                    'contract_id' =>
                        'Le contrat sélectionné ne possède pas de client.',
                ]);
        }

        /*
         * Vérification du véhicule
         */
        if (!$vehicle) {
            return back()
                ->withInput()
                ->withErrors([
                    'contract_id' =>
                        'Le contrat sélectionné ne possède pas de véhicule.',
                ]);
        }

        /*
         * Création de l'infraction
         *
         * Les données du client, véhicule et contrat
         * sont copiées automatiquement.
         */
        Infraction::create([
            'contract_id' => $contract->id,

            // Client
            'client_id' => $client->id,
            'nom' => $client->nom,
            'prenom' => $client->prenom,
            'cin' => $client->cin,
            'numero_permis' => $client->numero_permis,
            'adresse' => $client->adresse,
            'ville' => $client->ville,
            'code_postal' => $client->code_postal,
            'telephone' => $client->telephone,
            'email' => $client->email,

            // Véhicule
            'vehicle_id' => $vehicle->id,
            'immatriculation' => $vehicle->immatriculation,
            'marque' => $vehicle->marque,
            'modele' => $vehicle->modele,

            // Contrat
            'numero_contrat' => $contract->numero,
            'date_depart' => $contract->date_depart,
            'heure_depart' => $contract->heure_depart,
            'date_retour' => $contract->date_retour,
            'heure_retour' => $contract->heure_retour,
        ]);

        return redirect()
            ->route('infractions.index')
            ->with(
                'success',
                'Infraction créée avec succès.'
            );
    }

    /**
     * --------------------------------------------------------------------------
     * Show
     * --------------------------------------------------------------------------
     */
    public function show(
        Infraction $infraction
    ): View {

        $infraction->load([
            'client',
            'vehicle',
            'contract',
        ]);

        return view(
            'infractions.show',
            compact('infraction')
        );
    }

    /**
     * Le modele est injecte par Laravel et deja filtre par TenantScope.
     * La vue Blade peut donc utiliser directement ses variables sans API.
     */
    public function pdf(Infraction $infraction): View
    {
        if ($this->usesContracts()) {
            return view('infractions.jspdf', ['id' => $infraction->id]);
        }

        return view('infractions.jspdf-sans-contrat', compact('infraction'));
    }

    /**
     * --------------------------------------------------------------------------
     * Edit
     * --------------------------------------------------------------------------
     */
    public function edit(
        Infraction $infraction
    ): View {

        $usesContracts = $this->usesContracts();

        if (! $usesContracts) {
            $clients = Client::orderBy('nom')->orderBy('prenom')->get();
            $vehicles = Vehicle::orderBy('immatriculation')->get();

            return view('infractions.edit', compact('infraction', 'usesContracts', 'clients', 'vehicles'));
        }

        $contracts = Contract::with([
            'client',
            'vehicle',
        ])
            ->latest()
            ->get();

        return view(
            'infractions.edit',
            compact(
                'infraction',
                'contracts',
                'usesContracts'
            )
        );
    }

    /**
     * --------------------------------------------------------------------------
     * Update
     * --------------------------------------------------------------------------
     */
    public function update(
        InfractionRequest $request,
        Infraction $infraction
    ): RedirectResponse {

        if (! $this->usesContracts()) {
            $infraction->update($this->manualInfractionData($request->validated()));

            return redirect()
                ->route('infractions.index')
                ->with('success', 'Infraction modifiee avec succes.');
        }

        $contract = Contract::with([
            'client',
            'vehicle',
        ])->findOrFail(
            $request->validated('contract_id')
        );

        $client = $contract->client;
        $vehicle = $contract->vehicle;

        /*
         * Vérification du client
         */
        if (!$client) {
            return back()
                ->withInput()
                ->withErrors([
                    'contract_id' =>
                        'Le contrat sélectionné ne possède pas de client.',
                ]);
        }

        /*
         * Vérification du véhicule
         */
        if (!$vehicle) {
            return back()
                ->withInput()
                ->withErrors([
                    'contract_id' =>
                        'Le contrat sélectionné ne possède pas de véhicule.',
                ]);
        }

        /*
         * Mise à jour
         */
        $infraction->update([
            'contract_id' => $contract->id,

            // Client
            'client_id' => $client->id,
            'nom' => $client->nom,
            'prenom' => $client->prenom,
            'cin' => $client->cin,
            'numero_permis' => $client->numero_permis,
            'adresse' => $client->adresse,
            'ville' => $client->ville,
            'code_postal' => $client->code_postal,
            'telephone' => $client->telephone,
            'email' => $client->email,

            // Véhicule
            'vehicle_id' => $vehicle->id,
            'immatriculation' => $vehicle->immatriculation,
            'marque' => $vehicle->marque,
            'modele' => $vehicle->modele,

            // Contrat
            'numero_contrat' => $contract->numero,
            'date_depart' => $contract->date_depart,
            'heure_depart' => $contract->heure_depart,
            'date_retour' => $contract->date_retour,
            'heure_retour' => $contract->heure_retour,
        ]);

        return redirect()
            ->route('infractions.index')
            ->with(
                'success',
                'Infraction modifiée avec succès.'
            );
    }

    public function printDocument($id)
        {
            // On passe juste l'ID, car le JavaScript va charger le reste des données via l'API
            return view('infractions.print', ['infractionId' => $id]);
        }

    /**
     * --------------------------------------------------------------------------
     * Destroy
     * --------------------------------------------------------------------------
     */
    public function destroy(
        Infraction $infraction
    ): RedirectResponse {

        $infraction->delete();

        return redirect()
            ->route('infractions.index')
            ->with(
                'success',
                'Infraction supprimée avec succès.'
            );
    }

    private function usesContracts(): bool
    {
        return auth()->user()?->can('view-contracts') ?? false;
    }

    /**
     * Copie les donnees du client et du vehicule selectionnes dans le tenant
     * courant. Les requetes Eloquent appliquent le TenantScope, ce qui empeche
     * de declarer une infraction avec des donnees d'une autre agence.
     */
    private function manualInfractionData(array $validated): array
    {
        $client = Client::findOrFail($validated['client_id']);
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        return [
            'client_id' => $client->id,
            'vehicle_id' => $vehicle->id,
            'nom' => $client->nom,
            'prenom' => $client->prenom,
            'cin' => $client->cin,
            'numero_permis' => $client->numero_permis,
            'adresse' => $client->adresse,
            'ville' => $client->ville,
            'code_postal' => $client->code_postal,
            'telephone' => $client->telephone,
            'email' => $client->email,
            'immatriculation' => $vehicle->immatriculation,
            'marque' => $vehicle->marque,
            'modele' => $vehicle->modele,
            // Période de location saisie manuellement pour une infraction sans contrat.
            'date_depart' => $validated['date_depart'] ?? null,
            'heure_depart' => $validated['heure_depart'] ?? null,
            'date_retour' => $validated['date_retour'] ?? null,
            'heure_retour' => $validated['heure_retour'] ?? null,
        ];
    }
}
