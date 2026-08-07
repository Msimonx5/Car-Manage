<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Vehicle;
use App\Enums\ContractStatus;
use App\Enums\VehicleStatus;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistiques générales
        |--------------------------------------------------------------------------
        */

        $totalClients = Client::count();

        $totalVehicles = Vehicle::count();

        $totalContracts = Contract::count();


        /*
        |--------------------------------------------------------------------------
        | Véhicules par statut
        |--------------------------------------------------------------------------
        */

        $availableVehicles = Vehicle::where(
            'statut',
            VehicleStatus::DISPONIBLE->value
        )->count();

        $rentedVehicles = Vehicle::where(
            'statut',
            VehicleStatus::LOUE->value
        )->count();

        $maintenanceVehicles = Vehicle::where(
            'statut',
            VehicleStatus::MAINTENANCE->value
        )->count();

        $reservedVehicles = Vehicle::where(
            'statut',
            VehicleStatus::RESERVE->value
        )->count();

        $outOfServiceVehicles = Vehicle::where(
            'statut',
            VehicleStatus::HORS_SERVICE->value
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Contrats par statut
        |--------------------------------------------------------------------------
        */

        $pendingContracts = Contract::where(
            'statut',
            ContractStatus::EN_ATTENTE->value
        )->count();

        $activeContracts = Contract::where(
            'statut',
            ContractStatus::EN_COURS->value
        )->count();

        $finishedContracts = Contract::where(
            'statut',
            ContractStatus::TERMINE->value
        )->count();

        $cancelledContracts = Contract::where(
            'statut',
            ContractStatus::ANNULE->value
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Chiffre d'affaires
        |--------------------------------------------------------------------------
        */

        $totalRevenue = Contract::where(
            'statut',
            '!=',
            ContractStatus::ANNULE->value
        )->sum('total_ttc');

        $monthlyRevenue = Contract::where(
            'statut',
            '!=',
            ContractStatus::ANNULE->value
        )
        ->whereMonth('date_depart', now()->month)
        ->whereYear('date_depart', now()->year)
        ->sum('total_ttc');


        /*
        |--------------------------------------------------------------------------
        | Contrats récents
        |--------------------------------------------------------------------------
        */

        $recentContracts = Contract::with([
            'client',
            'vehicle'
        ])
        ->latest()
        ->take(10)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Contrats à retourner aujourd'hui
        |--------------------------------------------------------------------------
        */

        $contractsToday = Contract::with([
            'client',
            'vehicle'
        ])
        ->whereDate('date_retour', today())
        ->where(
            'statut',
            ContractStatus::EN_COURS->value
        )
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Véhicules nécessitant une attention
        |--------------------------------------------------------------------------
        */

        $vehicles = Vehicle::all();

        $oilChangeAlerts = $vehicles
            ->filter(fn ($vehicle) =>
                $vehicle->oil_change_status === 'danger'
            );

        $insuranceAlerts = $vehicles
            ->filter(fn ($vehicle) =>
                $vehicle->insurance_status === 'danger'
            );

        $technicalAlerts = $vehicles
            ->filter(fn ($vehicle) =>
                $vehicle->technical_status === 'danger'
            );


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

            'pendingContracts',
            'activeContracts',
            'finishedContracts',
            'cancelledContracts',

            'totalRevenue',
            'monthlyRevenue',

            'recentContracts',
            'contractsToday',

            'oilChangeAlerts',
            'insuranceAlerts',
            'technicalAlerts',

        ));
    }
}