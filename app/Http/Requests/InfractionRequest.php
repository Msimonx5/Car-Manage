<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfractionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (! $this->user()?->can('view-contracts')) {
            return [
                'client_id' => ['required', 'exists:clients,id'],
                'vehicle_id' => ['required', 'exists:vehicles,id'],
            ];
        }

        return [
            /*
             * Seul ce champ est réellement soumis par le formulaire.
             * Toutes les autres informations (client, véhicule, contrat)
             * sont dérivées automatiquement dans le contrôleur à partir
             * du contrat sélectionné, elles ne doivent donc pas être
             * validées ici (elles ne sont jamais envoyées en POST).
             */
            'contract_id' => [
                'required',
                'exists:contracts,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'contract_id.required' => 'Veuillez sélectionner un contrat.',
            'contract_id.exists' => 'Le contrat sélectionné est invalide.',
        ];
    }
}
