<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        $client = $this->route('client');

        return [

            'type' => [
                'required',
                Rule::in(['principal', 'secondaire']),
            ],

            'nom' => [
                'required',
                'string',
                'max:100',
            ],

            'prenom' => [
                'required',
                'string',
                'max:100',
            ],

            'date_naissance' => [
                'nullable',
                'date',
                'before:today',
            ],

            'lieu_naissance' => [
                'nullable',
                'string',
                'max:150',
            ],

            'adresse' => [
                'nullable',
                'string',
                'max:500',
            ],

            'cin' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clients', 'cin')->ignore($client),
            ],

            'nationalite' => [
                'nullable',
                'string',
                'max:100',
            ],

            'numero_permis' => [
                'required',
                'string',
                'max:50',
                Rule::unique('clients', 'numero_permis')->ignore($client),
            ],

            'numero_passeport' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('clients', 'numero_passeport')->ignore($client),
            ],

            'adresse_etranger' => [
                'nullable',
                'string',
                'max:500',
            ],

            'telephone' => [
                'required',
                'string',
                'max:20',
            ],

        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'type.required' => 'Le type de client est obligatoire.',
            'type.in' => 'Le type doit être principal ou secondaire.',

            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 100 caractères.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 100 caractères.',

            'date_naissance.date' => 'La date de naissance est invalide.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',

            'lieu_naissance.max' => 'Le lieu de naissance est trop long.',

            'cin.required' => 'Le numéro CIN est obligatoire.',
            'cin.unique' => 'Ce numéro CIN existe déjà.',

            'numero_permis.required' => 'Le numéro de permis est obligatoire.',
            'numero_permis.unique' => 'Ce numéro de permis existe déjà.',

            'numero_passeport.unique' => 'Ce numéro de passeport existe déjà.',

            'telephone.required' => 'Le numéro de téléphone est obligatoire.',

        ];
    }

    /**
     * Friendly attribute names.
     */
    public function attributes(): array
    {
        return [

            'type' => 'type',

            'nom' => 'nom',

            'prenom' => 'prénom',

            'date_naissance' => 'date de naissance',

            'lieu_naissance' => 'lieu de naissance',

            'adresse' => 'adresse',

            'cin' => 'CIN',

            'nationalite' => 'nationalité',

            'numero_permis' => 'numéro de permis',

            'numero_passeport' => 'numéro de passeport',

            'adresse_etranger' => 'adresse à l\'étranger',

            'telephone' => 'téléphone',

        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nom' => strtoupper(trim($this->nom)),
            'prenom' => ucfirst(strtolower(trim($this->prenom))),
            'cin' => strtoupper(trim($this->cin)),
            'numero_permis' => strtoupper(trim($this->numero_permis)),
            'numero_passeport' => $this->numero_passeport
                ? strtoupper(trim($this->numero_passeport))
                : null,
        ]);
    }
}