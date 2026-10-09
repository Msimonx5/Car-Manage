<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Infraction;
use App\Models\Vehicle;
use App\Enums\ContractStatus;
use App\Enums\VehicleStatus;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistiques générales
        |--------------------------------------------------------------------------
        */

        $totalClients   = Client::count();
        $totalVehicles  = Vehicle::count();
        $totalContracts = Contract::count();

        /*
        |--------------------------------------------------------------------------
        | Véhicules par statut
        |--------------------------------------------------------------------------
        */

        $availableVehicles    = Vehicle::where('statut', VehicleStatus::DISPONIBLE->value)->count();
        $rentedVehicles       = Vehicle::where('statut', VehicleStatus::LOUE->value)->count();
        $maintenanceVehicles  = Vehicle::where('statut', VehicleStatus::MAINTENANCE->value)->count();
        $reservedVehicles     = Vehicle::where('statut', VehicleStatus::RESERVE->value)->count();
        $outOfServiceVehicles = Vehicle::where('statut', VehicleStatus::HORS_SERVICE->value)->count();

        // Taux d'utilisation de la flotte (véhicules loués / total)
        $fleetUtilization = $totalVehicles > 0
            ? (int) round(($rentedVehicles / $totalVehicles) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Contrats par statut
        |--------------------------------------------------------------------------
        */

        $pendingContracts   = Contract::where('statut', ContractStatus::EN_ATTENTE->value)->count();
        $activeContracts    = Contract::where('statut', ContractStatus::EN_COURS->value)->count();
        $finishedContracts  = Contract::where('statut', ContractStatus::TERMINE->value)->count();
        $cancelledContracts = Contract::where('statut', ContractStatus::ANNULE->value)->count();

        // Taux de conversion (contrats non annulés / total)
        $conversionRate = $totalContracts > 0
            ? (int) round((($totalContracts - $cancelledContracts) / $totalContracts) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Chiffre d'affaires
        |--------------------------------------------------------------------------
        */

        $usesContracts = auth()->user()?->can('view-contracts') ?? false;
        if ($usesContracts) {
            $revenueBase = fn () => Contract::where('statut', '!=', ContractStatus::ANNULE->value);
            $revenueSum = fn ($query) => (float) $query->sum('total_ttc');
        } else {
            $revenueBase = fn () => Infraction::query()
                ->whereNotNull('date_depart')
                ->whereNotNull('date_retour')
                ->whereNotNull('tarif_jour');
            $revenueSum = fn ($query) => (float) $query
                ->selectRaw('COALESCE(SUM(tarif_jour * GREATEST(1, DATEDIFF(date_retour, date_depart))), 0) as aggregate')
                ->value('aggregate');
        }

        $totalRevenue = $revenueSum($revenueBase());

        $monthlyRevenue = $revenueSum($revenueBase()
            ->whereMonth('date_depart', now()->month)
            ->whereYear('date_depart', now()->year));

        // Chiffre d'affaires du mois précédent (pour la tendance)
        $lastMonth = now()->copy()->subMonthNoOverflow();

        $lastMonthRevenue = $revenueSum($revenueBase()
            ->whereMonth('date_depart', $lastMonth->month)
            ->whereYear('date_depart', $lastMonth->year));

        $revenueTrend = $lastMonthRevenue > 0
            ? (int) round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : null;

        // Nouveaux clients ce mois-ci
        $newClientsThisMonth = Client::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Série du chiffre d'affaires (6 derniers mois)
        |--------------------------------------------------------------------------
        */

        $revenueSeries = collect(range(5, 0))->map(function ($i) use ($revenueBase, $revenueSum) {

            $month = now()->copy()->subMonthsNoOverflow($i);

            $value = $revenueSum($revenueBase()
                ->whereMonth('date_depart', $month->month)
                ->whereYear('date_depart', $month->year));

            return [
                'label' => ucfirst($month->locale('fr')->isoFormat('MMM')),
                'value' => (float) $value,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Contrats récents
        |--------------------------------------------------------------------------
        */

        $recentContracts = Contract::with(['client', 'vehicle'])
            ->orderByDesc('date_depart')
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Contrats à retourner aujourd'hui
        |--------------------------------------------------------------------------
        */

        $contractsToday = Contract::with(['client', 'vehicle'])
            ->whereDate('date_retour', today())
            ->where('statut', ContractStatus::EN_COURS->value)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Alertes véhicules (vidange / assurance / visite technique)
        |--------------------------------------------------------------------------
        */

        $vehicles = Vehicle::all();

        $alerts = collect();

        foreach ($vehicles->where('oil_change_status', 'danger') as $vehicle) {
            $alerts->push([
                'icon'   => 'bi-tools',
                'tint'   => 'danger',
                'title'  => 'Vidange — ' . $vehicle->full_name,
                'detail' => number_format($vehicle->kilometrage, 0, ',', ' ') . ' km · dépassé',
                'badge'  => 'Urgent',
                'class'  => 'annule',
            ]);
        }

        foreach ($vehicles->where('insurance_status', 'danger') as $vehicle) {
            $alerts->push([
                'icon'   => 'bi-shield-exclamation',
                'tint'   => 'warning',
                'title'  => 'Assurance — ' . $vehicle->full_name,
                'detail' => 'Expirée le ' . optional($vehicle->assurance_expiration)->format('d/m/Y'),
                'badge'  => 'Expirée',
                'class'  => 'annule',
            ]);
        }

        foreach ($vehicles->where('technical_status', 'danger') as $vehicle) {
            $alerts->push([
                'icon'   => 'bi-clipboard2-x',
                'tint'   => 'danger',
                'title'  => 'Visite technique — ' . $vehicle->full_name,
                'detail' => 'Expirée le ' . optional($vehicle->visite_technique)->format('d/m/Y'),
                'badge'  => 'Expirée',
                'class'  => 'annule',
            ]);
        }

        $alerts = $alerts->take(6);

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalClients',
            'totalVehicles',
            'totalContracts',
            'availableVehicles',
            'rentedVehicles',
            'maintenanceVehicles',
            'reservedVehicles',
            'outOfServiceVehicles',
            'fleetUtilization',
            'pendingContracts',
            'activeContracts',
            'finishedContracts',
            'cancelledContracts',
            'conversionRate',
            'totalRevenue',
            'monthlyRevenue',
            'revenueTrend',
            'newClientsThisMonth',
            'revenueSeries',
            'recentContracts',
            'contractsToday',
            'alerts',
        ));
    }
}
