<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'pseudonyme' => ['required', 'unique'],
            'prenom' => ['required'],
            'nom' => ['required'],
            'email' => ['required'],
            'statut' => ['required']
          ];
    }

    public function messages()
    {
        return [
            'pseudonyme.required' => 'Il faut spécifier un pseudonyme',
            'pseudonyme.unique' => 'Pseudonyme déjà utilisé',
            'prenom.required' => 'Il faut spécifier un prenom',
            'nom.required' => 'Il faut spécifier un nom',
            'email.required' => 'Il faut spécifier une adresse mail'
        ];
    }

    public function attributes()
    {
        return [
            'pseudonyme' => 'pseudonyme',
            'prenom' => 'prenom',
            'nom' => 'nom',
            'email' => 'email',
            'statut' => 'statut'
        ];
    }
}
