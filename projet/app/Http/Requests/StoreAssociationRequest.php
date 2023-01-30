<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssociationRequest extends FormRequest
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
            'nom' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Il faut spécifier un nom',
        ];
    }

    public function attributes(){
        return [
            'nom'=>'nom'
        ];
    }
}
