<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InfractionRequest;
use App\Http\Resources\InfractionResource;
use App\Models\Contract;
use App\Models\Infraction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiInfractionController extends Controller
{
    /**
     * Display a listing of the infractions.
     */
    public function index(): JsonResponse
    {
        $query = Infraction::with(['client', 'vehicle', 'contract']);

        // Recherche (Search)
        if ($q = request('q')) {
            $query->where(function ($query) use ($q) {
                $query->where('numero_contrat', 'like', "%{$q}%")
                    ->orWhere('immatriculation', 'like', "%{$q}%")
                    ->orWhere('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('cin', 'like', "%{$q}%")
                    ->orWhere('numero_permis', 'like', "%{$q}%")
                    ->orWhere('ville', 'like', "%{$q}%");
            });
        }

        $infractions = $query->latest()->paginate(20);

        return InfractionResource::collection($infractions)
            ->additional([
                'stats' => [
                    'total' => Infraction::count(),
                ]
            ])
            ->response();
    }

    /**
     * Store a newly created infraction.
     */
    public function store(InfractionRequest $request): JsonResponse
    {
        $contract = Contract::with(['client', 'vehicle'])
            ->findOrFail($request->validated('contract_id'));

        $errorResponse = $this->validateContractData($contract);
        if ($errorResponse) return $errorResponse;

        $data = $this->mapContractToInfractionData($contract);
        $infraction = Infraction::create($data);

        return (new InfractionResource($infraction))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified infraction.
     */
    public function show(Infraction $infraction): InfractionResource
    {
        return new InfractionResource($infraction->load(['client', 'vehicle', 'contract']));
    }

    /**
     * Update the specified infraction.
     */
    public function update(InfractionRequest $request, Infraction $infraction): JsonResponse
    {
        $contract = Contract::with(['client', 'vehicle'])
            ->findOrFail($request->validated('contract_id'));

        $errorResponse = $this->validateContractData($contract);
        if ($errorResponse) return $errorResponse;

        $data = $this->mapContractToInfractionData($contract);
        $infraction->update($data);

        return (new InfractionResource($infraction))
            ->response();
    }

    /**
     * Remove the specified infraction.
     */
    public function destroy(Infraction $infraction): JsonResponse
    {
        $infraction->delete();

        return response()->json([
            'message' => 'Infraction supprimée avec succès.'
        ], 200); // Or 204 No Content
    }

    /**
     * Logic to validate if the contract has the required relations.
     */
    private function validateContractData($contract): ?JsonResponse
    {
        if (!$contract->client) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => ['contract_id' => ['Le contrat sélectionné ne possède pas de client.']]
            ], 422);
        }

        if (!$contract->vehicle) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => ['contract_id' => ['Le contrat sélectionné ne possède pas de véhicule.']]
            ], 422);
        }

        return null;
    }

    /**
     * Map Contract/Client/Vehicle data to Infraction array.
     */
    private function mapContractToInfractionData(Contract $contract): array
    {
        $client = $contract->client;
        $vehicle = $contract->vehicle;

        return [
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
        ];
    }
}