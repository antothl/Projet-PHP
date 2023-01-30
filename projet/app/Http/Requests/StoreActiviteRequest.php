<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActiviteRequest extends FormRequest
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
            'titre' => ['required', 'max:100'],
            'description' => ['required'],
            'dateDebut' => ['required','after:today', 'date'],
            'dateFin' => ['required','after:dateDebut', 'date'],
            'places' => ['required'],
            'association_id' => ['required']
          ];
    }

    public function messages()
    {
        return [
            'titre.required' => 'Il faut spécifier un titre',
            'titre.max' => 'Le titre ne doit pas contenir plus de 100 caractères',
            'description.required' => 'Il faut spécifier une description',
            'dateDebut.required' => 'Il faut spécifier une date de début',
            'dateDebut.date' => 'Le format de la date de début est incorrect',
            'dateDebut.after' => 'La date de début doit être postérieure à la date actuelle',
            'dateFin.required' => 'Il faut spécifier une date de fin',
            'dateFin.date' => 'Le format de la date de début est fin',
            'dateFin.after' => 'La date de fin doit être postérieure à la date de début',
            'places.required' => 'Il faut spécifier un nombre de places',
            'association_id.required' => 'Il faut spécifier une association'
        ];
    }

    public function attributes()
    {
        return [
            'titre' => 'titre',
            'description' => 'description',
            'dateDebut' => 'dateDebut',
            'dateFin' => 'dateFin',
            'places' => 'places',
            'association_id' => 'association_id'
        ];
    }
}
