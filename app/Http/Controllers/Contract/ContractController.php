<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Enums\VehicleStatus;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Vehicle;
use App\Support\ExcelCsvExport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    /**
     * Liste des contrats.
     */
    public function index(Request $request): View
    {
        Contract::releaseExpired();

        $contracts = $this->filteredContracts($request)
            ->paginate(10)
            ->withQueryString();

        $stats = [

            'total' => Contract::count(),

            'en_attente' => Contract::where('statut', 'en_attente')->count(),

            'en_cours' => Contract::where('statut', 'en_cours')->count(),

            'termine' => Contract::where('statut', 'termine')->count(),

            'annule' => Contract::where('statut', 'annule')->count(),

            'chiffre_affaires' => Contract::sum('total_ttc'),

        ];

        return view('contracts.index', compact(
            'contracts',
            'stats'
        ));
    }

    public function export(Request $request)
    {
        Contract::releaseExpired();

        $rows = $this->filteredContracts($request)->lazy(500)->map(static fn (Contract $contract): array => [
            $contract->id,
            $contract->numero,
            $contract->client?->nom,
            $contract->client?->prenom,
            $contract->vehicle?->immatriculation,
            $contract->vehicle?->marque,
            $contract->vehicle?->modele,
            $contract->date_depart?->format('Y-m-d'),
            $contract->heure_depart,
            $contract->date_retour?->format('Y-m-d'),
            $contract->heure_retour,
            $contract->nombre_jours,
            $contract->km_depart,
            $contract->km_retour,
            $contract->tarif_jour,
            $contract->total_ht,
            $contract->tva,
            $contract->total_ttc,
            $contract->avance,
            max(0, (float) $contract->total_ttc - (float) $contract->avance),
            $contract->caution,
            $contract->mode_paiement,
            $contract->statut->label(),
            $contract->observation,
        ]);

        return ExcelCsvExport::download(
            'contrats-'.now()->format('Y-m-d').'.csv',
            ['ID', 'N° contrat', 'Nom du client', 'Prénom du client', 'Immatriculation', 'Marque', 'Modèle', 'Date de départ', 'Heure de départ', 'Date de retour', 'Heure de retour', 'Durée (jours)', 'Km départ', 'Km retour', 'Tarif journalier', 'Total HT', 'TVA', 'Total TTC', 'Avance', 'Reste à payer', 'Caution', 'Mode de paiement', 'Statut', 'Observations'],
            $rows,
        );
    }

    private function filteredContracts(Request $request): Builder
    {
        $query = Contract::query()
            ->with([
                'client:id,nom,prenom',
                'vehicle:id,marque,modele,immatriculation',
            ]);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($client) use ($search) {
                        $client->where('nom', 'like', "%{$search}%")
                            ->orWhere('prenom', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicle', function ($vehicle) use ($search) {
                        $vehicle->where('immatriculation', 'like', "%{$search}%")
                            ->orWhere('marque', 'like', "%{$search}%")
                            ->orWhere('modele', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        return $query->latest();
    }

    /**
     * Formulaire création.
     */
    public function create(): View
    {
        Contract::releaseExpired();

        return view('contracts.create', [

            'clients' => Client::orderBy('nom')->get(),

            'vehicles' => Vehicle::where('statut', 'disponible')
                ->orderBy('marque')
                ->get(),

        ]);
    }

    /**
     * Enregistrement.
     */
    public function store(StoreContractRequest $request): RedirectResponse
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Calcul automatique
        |--------------------------------------------------------------------------
        */

        $depart = Carbon::parse($data['date_depart'])->startOfDay();
        $retour = Carbon::parse($data['date_retour'])->startOfDay();

        $data['nombre_jours'] = max(1, $depart->diffInDays($retour));

        // $data['total_ht'] =
        //     $data['tarif_jour'] *
        //     $data['nombre_jours'];

        // $data['tva'] =
        //     $data['total_ht'] * 0.20;

        // $data['total_ttc'] =
        //     $data['total_ht'] +
        //     $data['tva'];
        $data['total_ht'] =
            $data['tarif_jour'] *
            $data['nombre_jours'];

        $data['tva'] = 0;

        $data['total_ttc'] =
            $data['total_ht'];

        /*
        |--------------------------------------------------------------------------
        | Création du contrat
        |--------------------------------------------------------------------------
        */

        $contract = DB::transaction(function () use ($data) {

            // On crée d'abord le contrat sans numéro
            $contract = Contract::create($data);

            // L'ID est maintenant connu et unique
            $contract->update([
                'numero' =>
                    'CTR-' .
                    now()->format('Ymd') .
                    '-' .
                    str_pad(
                        $contract->id,
                        5,
                        '0',
                        STR_PAD_LEFT
                    ),
            ]);

            return $contract;
        });

        /*
        |--------------------------------------------------------------------------
        | Véhicule loué
        |--------------------------------------------------------------------------
        */

        $contract->syncVehicleStatus();
        $contract->syncVehicleMileage();

        return redirect()
            ->route('contracts.index')
            ->with(
                'success',
                'Contrat créé avec succès.'
            );
    }

    /**
     * Détails.
     */
    public function show(Contract $contract): View
    {
        $contract->load([
            'client',
            'vehicle',
            'secondDriver',
        ]);

        return view(
            'contracts.show',
            compact('contract')
        );
    }

    /**
     * Formulaire modification.
     */
    public function edit(Contract $contract): View
    {
        return view('contracts.edit', [

            'contract' => $contract,

            'clients' => Client::orderBy('nom')->get(),

            'vehicles' => Vehicle::orderBy('marque')->get(),

        ]);
    }

    /**
     * Mise à jour.
     */
    public function update(
        UpdateContractRequest $request,
        Contract $contract
    ): RedirectResponse {

        $data = $request->validated();

    $depart = Carbon::parse($data['date_depart'])->startOfDay();
    $retour = Carbon::parse($data['date_retour'])->startOfDay();

    $data['nombre_jours'] = max(1, $depart->diffInDays($retour));

        // $data['total_ht'] =
        //     $data['tarif_jour'] *
        //     $data['nombre_jours'];

        // $data['tva'] =
        //     $data['total_ht'] * 0.20;

        // $data['total_ttc'] =
        //     $data['total_ht'] +
        //     $data['tva'];
        $data['total_ht'] =
            $data['tarif_jour'] *
            $data['nombre_jours'];

        $data['tva'] = 0;

        $data['total_ttc'] =
            $data['total_ht'];
        $previousVehicleId = $contract->vehicle_id;

        $contract->update($data);

        /*
        |--------------------------------------------------------------------------
        | Synchronisation du statut véhicule
        |--------------------------------------------------------------------------
        */

        if ($previousVehicleId != $contract->vehicle_id) {

            Vehicle::whereKey($previousVehicleId)->update([
                'statut' => VehicleStatus::DISPONIBLE,
            ]);

        }

        $contract->syncVehicleStatus();
        $contract->syncVehicleMileage();

        return redirect()
            ->route('contracts.index')
            ->with(
                'success',
                'Contrat modifié avec succès.'
            );
    }

    /**
     * Suppression.
     */
    public function destroy(
        Contract $contract
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Remettre le véhicule disponible
        |--------------------------------------------------------------------------
        */

        $contract->vehicle->update([

            'statut' => VehicleStatus::DISPONIBLE,

        ]);

        $contract->delete();

        return redirect()
            ->route('contracts.index')
            ->with(
                'success',
                'Contrat supprimé avec succès.'
            );
    }
}