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
        $financialRules = [
            'tarif_jour' => ['required', 'numeric', 'min:0'],
            'avance' => ['required', 'numeric', 'min:0'],
        ];

        if (! $this->user()?->can('view-contracts')) {
            return array_merge($financialRules, [
                'client_id' => ['required', 'exists:clients,id'],
                'vehicle_id' => ['required', 'exists:vehicles,id'],
                'date_depart' => ['nullable', 'date'],
                'heure_depart' => ['nullable', 'date_format:H:i'],
                'date_retour' => ['nullable', 'date', 'after_or_equal:date_depart'],
                'heure_retour' => ['nullable', 'date_format:H:i'],
            ]);
        }

        return array_merge($financialRules, [
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
        ]);
    }

    public function messages(): array
    {
        return [
            'date_retour.after_or_equal' => 'La date de retour doit être postérieure ou égale à la date de départ.',
            'contract_id.required' => 'Veuillez sélectionner un contrat.',
            'contract_id.exists' => 'Le contrat sélectionné est invalide.',
        ];
    }
}
