<?php

namespace App\Http\Requests\Vehicle;

use App\Enums\VehicleStatus;
use App\Support\Tenancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $vehicle = $this->route('vehicle');

        return [

            /*
            |--------------------------------------------------------------------------
            | Informations générales
            |--------------------------------------------------------------------------
            */

            'marque' => [
                'required',
                'string',
                'max:100',
            ],

            'modele' => [
                'required',
                'string',
                'max:100',
            ],

            'annee' => [
                'required',
                'integer',
                'digits:4',
                'min:1990',
                'max:' . (date('Y') + 1),
            ],

            'couleur' => [
                'nullable',
                'string',
                'max:50',
            ],

            /*
            |--------------------------------------------------------------------------
            | Identification
            |--------------------------------------------------------------------------
            */

            'immatriculation' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vehicles', 'immatriculation')->ignore($vehicle)->where('tenant_id', Tenancy::currentId()),
            ],

            'numero_chassis' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('vehicles', 'numero_chassis')->ignore($vehicle)->where('tenant_id', Tenancy::currentId()),
            ],

            'numero_moteur' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | Caractéristiques
            |--------------------------------------------------------------------------
            */

            'carburant' => [
                'required',
                Rule::in([
                    'Essence',
                    'Diesel',
                    'Hybride',
                    'Electrique',
                ]),
            ],

            'boite_vitesse' => [
                'required',
                Rule::in([
                    'Manuelle',
                    'Automatique',
                ]),
            ],

            'nombre_places' => [
                'required',
                'integer',
                'min:2',
                'max:60',
            ],

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'prix_jour' => [
                'required',
                'numeric',
                'min:0',
            ],

            'caution' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Kilométrage
            |--------------------------------------------------------------------------
            */

            'kilometrage' => [
                'required',
                'integer',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Vidange
            |--------------------------------------------------------------------------
            */

            'derniere_vidange_km' => [
                'nullable',
                'integer',
                'lte:kilometrage',
            ],

            'prochaine_vidange_km' => [
                'nullable',
                'integer',
                'gte:kilometrage',
            ],

            'derniere_vidange_date' => [
                'nullable',
                'date',
            ],

            'filtre_air_date' => ['nullable', 'date'],
            'filtre_huile_date' => ['nullable', 'date'],
            'filtre_carburant_date' => ['nullable', 'date'],
            'filtre_habitacle_date' => ['nullable', 'date'],
            'pneus_date' => ['nullable', 'date'],
            'pneus_description' => ['nullable', 'string', 'max:255'],
            'plaquettes_frein_date' => ['nullable', 'date'],
            'plaquettes_frein_description' => ['nullable', 'string', 'max:255'],

            /*
            |--------------------------------------------------------------------------
            | Assurance
            |--------------------------------------------------------------------------
            */

            'assurance_expiration' => [
                'nullable',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Visite technique
            |--------------------------------------------------------------------------
            */

            'visite_technique' => [
                'nullable',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Statut
            |--------------------------------------------------------------------------
            */

            'statut' => [
                'required',
                Rule::enum(VehicleStatus::class),
            ],

            /*
            |--------------------------------------------------------------------------
            | Observation
            |--------------------------------------------------------------------------
            */

            'observation' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ];
    }

    /**
     * Messages personnalisés.
     */
    public function messages(): array
    {
        return [

            'immatriculation.unique' => 'Cette immatriculation existe déjà.',

            'numero_chassis.unique' => 'Ce numéro de châssis existe déjà.',

            'prochaine_vidange_km.gte' =>
                'La prochaine vidange doit être supérieure ou égale au kilométrage actuel.',

            'derniere_vidange_km.lte' =>
                'La dernière vidange ne peut pas être supérieure au kilométrage actuel.',

        ];
    }

    /**
     * Noms lisibles des attributs.
     */
    public function attributes(): array
    {
        return [

            'marque' => 'marque',

            'modele' => 'modèle',

            'annee' => 'année',

            'immatriculation' => 'immatriculation',

            'numero_chassis' => 'numéro de châssis',

            'numero_moteur' => 'numéro de moteur',

            'prix_jour' => 'prix par jour',

            'caution' => 'caution',

            'kilometrage' => 'kilométrage',

            'derniere_vidange_km' => 'dernière vidange',

            'prochaine_vidange_km' => 'prochaine vidange',

            'derniere_vidange_date' => 'date de vidange',

            'assurance_expiration' => 'expiration assurance',

            'visite_technique' => 'visite technique',

        ];
    }

    /**
     * Préparer les données.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'marque' => ucfirst(trim($this->marque)),

            'modele' => ucfirst(trim($this->modele)),

            'couleur' => $this->couleur
                ? ucfirst(trim($this->couleur))
                : null,

            'immatriculation' => strtoupper(trim($this->immatriculation)),

            'numero_chassis' => $this->numero_chassis
                ? strtoupper(trim($this->numero_chassis))
                : null,

            'numero_moteur' => $this->numero_moteur
                ? strtoupper(trim($this->numero_moteur))
                : null,

        ]);
    }
}
