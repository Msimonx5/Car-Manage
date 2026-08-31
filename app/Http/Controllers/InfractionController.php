<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfractionRequest;
use App\Models\Contract;
use App\Models\Infraction;
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
        $contracts = Contract::with([
            'client',
            'vehicle',
        ])
            ->latest()
            ->get();

        return view(
            'infractions.create',
            compact('contracts')
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
     * --------------------------------------------------------------------------
     * Edit
     * --------------------------------------------------------------------------
     */
    public function edit(
        Infraction $infraction
    ): View {

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
                'contracts'
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
}
