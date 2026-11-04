<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Models\Contract;
use App\Models\Vehicle;
use App\Support\ExcelCsvExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Vehicle\RecordOilChangeRequest; // <-- import à ajouter en haut
use App\Http\Requests\Vehicle\RecordVehicleMaintenanceRequest;

class VehicleController extends Controller
{
    /**
     * Liste des véhicules
     */
    public function index(Request $request): View
    {
        Contract::releaseExpired();

        $vehicles = $this->filteredVehicles($request)
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistiques
        |--------------------------------------------------------------------------
        */

        $stats = [

            'total' => Vehicle::count(),

            'disponible' => Vehicle::where(
                'statut',
                'disponible'
            )->count(),

            'loue' => Vehicle::where(
                'statut',
                'loue'
            )->count(),

            'maintenance' => Vehicle::where(
                'statut',
                'maintenance'
            )->count(),

            'reserve' => Vehicle::where(
                'statut',
                'reserve'
            )->count(),

            'hors_service' => Vehicle::where(
                'statut',
                'hors_service'
            )->count(),

            /*
            |--------------------------------------------------------------------------
            | Vidanges urgentes
            |--------------------------------------------------------------------------
            */

            'vidange_urgente' => Vehicle::whereColumn(
                'kilometrage',
                '>=',
                'prochaine_vidange_km'
            )->count(),
        ];

        return view(
            'vehicles.index',
            compact(
                'vehicles',
                'stats'
            )
        );
    }

    public function export(Request $request)
    {
        Contract::releaseExpired();

        $rows = $this->filteredVehicles($request)->lazy(500)->map(static fn (Vehicle $vehicle): array => [
            $vehicle->id,
            $vehicle->immatriculation,
            $vehicle->marque,
            $vehicle->modele,
            $vehicle->annee,
            $vehicle->couleur,
            $vehicle->carburant,
            $vehicle->boite_vitesse,
            $vehicle->nombre_places,
            $vehicle->numero_chassis,
            $vehicle->numero_moteur,
            $vehicle->prix_jour,
            $vehicle->caution,
            $vehicle->kilometrage,
            $vehicle->derniere_vidange_km,
            $vehicle->derniere_vidange_date?->format('Y-m-d'),
            $vehicle->prochaine_vidange_km,
            $vehicle->assurance_expiration?->format('Y-m-d'),
            $vehicle->visite_technique?->format('Y-m-d'),
            $vehicle->statut->label(),
            $vehicle->observation,
        ]);

        return ExcelCsvExport::download(
            'vehicules-'.now()->format('Y-m-d').'.csv',
            ['ID', 'Immatriculation', 'Marque', 'Modèle', 'Année', 'Couleur', 'Carburant', 'Boîte de vitesse', 'Places', 'N° châssis', 'N° moteur', 'Prix par jour', 'Caution', 'Kilométrage', 'Dernière vidange (km)', 'Dernière vidange (date)', 'Prochaine vidange (km)', 'Expiration assurance', 'Visite technique', 'Statut', 'Observations'],
            $rows,
        );
    }

    private function filteredVehicles(Request $request): Builder
    {
        $query = Vehicle::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('marque', 'like', "%{$search}%")
                    ->orWhere('modele', 'like', "%{$search}%")
                    ->orWhere('immatriculation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        switch ($request->get('sort', 'latest')) {
            case 'marque':
                $query->orderBy('marque');
                break;
            case 'kilometrage':
                $query->orderByDesc('kilometrage');
                break;
            case 'prix':
                $query->orderBy('prix_jour');
                break;
            default:
                $query->latest();
                break;
        }

        return $query;
    }

    /**
     * Formulaire création
     */
    public function create(): View
    {
        return view('vehicles.create');
    }

    /**
     * Enregistrer
     */
    public function store(
        StoreVehicleRequest $request
    ): RedirectResponse {

        Vehicle::create(
            $request->validated()
        );

        return redirect()
            ->route('vehicles.index')
            ->with(
                'success',
                'Véhicule ajouté avec succès.'
            );
    }

    /**
     * Détails
     */
    public function show(
        Vehicle $vehicle
    ): View {

        return view(
            'vehicles.show',
            compact('vehicle')
        );
    }

    /**
     * Formulaire modification
     */
    public function edit(
        Vehicle $vehicle
    ): View {

        return view(
            'vehicles.edit',
            compact('vehicle')
        );
    }

    /**
     * Mise à jour
     */
    public function update(
        UpdateVehicleRequest $request,
        Vehicle $vehicle
    ): RedirectResponse {

        $vehicle->update(
            $request->validated()
        );

        return redirect()
            ->route('vehicles.index')
            ->with(
                'success',
                'Véhicule modifié avec succès.'
            );
    }


// VehicleController.php


    public function addOilChange(RecordOilChangeRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $request->validated();

        $km = max($vehicle->kilometrage, $data['kilometrage_actuel']);

        $intervalle = $data['intervalle_km'] ?? 10000;

        DB::transaction(function () use ($vehicle, $km, $intervalle, $data) {
            $vehicle->update([
                'kilometrage'           => $km,
                'derniere_vidange_km'   => $km,
                'derniere_vidange_date' => now(),
                'prochaine_vidange_km'  => $km + $intervalle,
            ]);
        });

        return redirect()->back()->with('success', 'Vidange enregistrée avec succès.');
    }

    public function updateMaintenance(RecordVehicleMaintenanceRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->update($request->validated());

        return redirect()->back()->with('success', 'Suivi des filtres, pneus et freins mis à jour.');
    }

    /**
     * Suppression
     */
    public function destroy(
        Vehicle $vehicle
    ): RedirectResponse {

        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with(
                'success',
                'Véhicule supprimé avec succès.'
            );
    }
}
