<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KontaktRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>'required|email',
            'svrha'=>'required',
            'poruka'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'email.required'=>'Email je obavezan',
          'email.email'=>'Email nije u dobrom formatu',
          'svrha.required'=>'Svrha poruke je obavezna',
          'poruka.required'=>'Tekst poruke je obavezan',
        ];
    }
}
