<?php

namespace App\Http\Requests\Contract;

use App\Enums\ContractStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContractRequest extends FormRequest
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
        return [

            /*
            |--------------------------------------------------------------------------
            | Client
            |--------------------------------------------------------------------------
            */

            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'vehicle_id' => [
                'required',
                'exists:vehicles,id',
            ],

            'second_driver_id' => [
                'nullable',
                'different:client_id',
                'exists:clients,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Départ
            |--------------------------------------------------------------------------
            */

            'date_depart' => [
                'required',
                'date',
            ],

            'heure_depart' => [
                'required',
                'date_format:H:i',
            ],

            /*
            |--------------------------------------------------------------------------
            | Retour
            |--------------------------------------------------------------------------
            */

            'date_retour' => [
                'required',
                'date',
                'after_or_equal:date_depart',
            ],

            'heure_retour' => [
                'required',
                'date_format:H:i',
            ],

            /*
            |--------------------------------------------------------------------------
            | Kilométrage
            |--------------------------------------------------------------------------
            */

            'km_depart' => [
                'required',
                'integer',
                'min:0',
            ],

            'km_retour' => [
                'nullable',
                'integer',
                'gte:km_depart',
            ],

            /*
            |--------------------------------------------------------------------------
            | Tarification
            |--------------------------------------------------------------------------
            */

            'tarif_jour' => [
                'required',
                'numeric',
                'min:0',
            ],

            'nombre_jours' => [
                'required',
                'integer',
                'min:1',
            ],

            'avance' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'caution' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'total_ht' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tva' => [
                'required',
                'numeric',
                'min:0',
            ],

            'total_ttc' => [
                'required',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Paiement
            |--------------------------------------------------------------------------
            */

            'mode_paiement' => [
                'nullable',
                Rule::in([
                    'Espèces',
                    'Carte bancaire',
                    'Virement',
                    'Chèque',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Statut
            |--------------------------------------------------------------------------
            */

            'statut' => [
                'required',
                Rule::enum(ContractStatus::class),
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
     * Messages.
     */
    public function messages(): array
    {
        return [

            'date_retour.after_or_equal' =>
                'La date de retour doit être supérieure ou égale à la date de départ.',

            'km_retour.gte' =>
                'Le kilométrage retour doit être supérieur au kilométrage départ.',

            'second_driver_id.different' =>
                'Le deuxième conducteur doit être différent du client.',

        ];
    }

    /**
     * Préparation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'avance' => $this->avance ?: 0,

            'caution' => $this->caution ?: 0,

            'observation' => $this->observation
                ? trim($this->observation)
                : null,

        ]);
    }
}