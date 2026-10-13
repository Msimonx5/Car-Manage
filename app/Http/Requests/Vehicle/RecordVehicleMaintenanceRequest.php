<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class RecordVehicleMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'adblue_date' => ['nullable', 'string', 'max:255'],
            'filtre_air_date' => ['nullable', 'date'],
            'filtre_huile_date' => ['nullable', 'date'],
            'filtre_carburant_date' => ['nullable', 'date'],
            'filtre_habitacle_date' => ['nullable', 'date'],
            'pneus_date' => ['nullable', 'date'],
            'pneus_description' => ['nullable', 'string', 'max:255'],
            'plaquettes_frein_date' => ['nullable', 'date'],
            'plaquettes_frein_description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
