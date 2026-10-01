<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class RecordOilChangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kilometrage_actuel' => ['required', 'integer', 'min:0'],
            'intervalle_km'      => ['nullable', 'integer', 'min:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'kilometrage_actuel.required' => 'Le kilométrage actuel est obligatoire.',
            'kilometrage_actuel.integer'  => 'Le kilométrage doit être un nombre entier.',
            'intervalle_km.min'           => 'L\'intervalle doit être d\'au moins 1000 km.',
        ];
    }
}
