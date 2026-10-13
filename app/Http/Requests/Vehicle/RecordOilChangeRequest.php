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
            'intervalle_km'      => ['required', 'integer', 'in:10000,15000'],
        ];
    }

    public function messages(): array
    {
        return [
            'kilometrage_actuel.required' => 'Le kilométrage actuel est obligatoire.',
            'kilometrage_actuel.integer'  => 'Le kilométrage doit être un nombre entier.',
            'intervalle_km.in'            => 'Choisissez un intervalle de 10 000 ou 15 000 km.',
        ];
    }
}
