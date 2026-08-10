<?php

namespace App\Http\Requests\Vehicle;

use App\Enums\VehicleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'marque'=>['required','string','max:100'],

            'modele'=>['required','string','max:100'],

            'annee'=>['required','integer','digits:4','min:1990','max:2100'],

            'couleur'=>['nullable','string','max:50'],

            'immatriculation'=>[
                'required',
                'string',
                'max:50',
                'unique:vehicles'
            ],

            'numero_chassis'=>[
                'nullable',
                'string',
                'max:100',
                'unique:vehicles'
            ],

            'numero_moteur'=>[
                'nullable',
                'string',
                'max:100'
            ],

            'carburant'=>[
                'required',
                Rule::in([
                    'Essence',
                    'Diesel',
                    'Hybride',
                    'Electrique'
                ])
            ],

            'boite_vitesse'=>[
                'required',
                Rule::in([
                    'Manuelle',
                    'Automatique'
                ])
            ],

            'nombre_places'=>[
                'required',
                'integer',
                'min:2',
                'max:60'
            ],

            'prix_jour'=>[
                'required',
                'numeric',
                'min:0'
            ],

            'caution'=>[
                'nullable',
                'numeric',
                'min:0'
            ],

            'kilometrage'=>[
                'required',
                'integer',
                'min:0'
            ],

            'derniere_vidange_km'=>[
                'nullable',
                'integer'
            ],

            'prochaine_vidange_km'=>[
                'nullable',
                'integer',
                'gte:kilometrage'
            ],

            'derniere_vidange_date'=>[
                'nullable',
                'date'
            ],

            'assurance_expiration'=>[
                'nullable',
                'date'
            ],

            'visite_technique'=>[
                'nullable',
                'date'
            ],

            'statut'=>[
                'required',
                Rule::enum(VehicleStatus::class)
            ],

            'observation'=>[
                'nullable',
                'string'
            ]

        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([

            'marque'=>ucfirst(trim($this->marque)),

            'modele'=>ucfirst(trim($this->modele)),

            'immatriculation'=>strtoupper(trim($this->immatriculation)),

            'numero_chassis'=>$this->numero_chassis
                ? strtoupper(trim($this->numero_chassis))
                : null,

            'numero_moteur'=>$this->numero_moteur
                ? strtoupper(trim($this->numero_moteur))
                : null,

        ]);
    }
}