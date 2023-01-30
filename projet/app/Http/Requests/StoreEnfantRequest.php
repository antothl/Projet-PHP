<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnfantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nom' => ['required'],
            'prenom' => ['required'],
            'birth' => ['required','before:today','date'],
            'user_id' => ['required'],
          ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Il faut spécifier un nom',
            'prenom.required' => 'Il faut spécifier un prénom',
            'birth.required' => 'Il faut spécifier une date de naissance',
            'birth.date' => 'Le format de la date de naissance est incorrect',
            'birth.before' => 'La date de naissance doit être antérieure à la date actuelle',
            'user_id.required' => 'Il faut spécifier un parent',
        ];
    }

    public function attributes()
    {
        return [
                'nom' => 'nom',
                'prenom' => 'prenom',
                'birth' => 'birth',
                'user_id' => 'user_id'
            ];
    }
}
