<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfilRequest extends FormRequest
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
        $id=$this->input('skriveno');

        return [
            'email'=>[
                'required',
                'email',
                Rule::unique('korisnik', 'email')->ignore($id,'idKorisnik'),
            ],
            'username'=>[
                'required',
                'regex:/^[\d\w\_\-\.\@]{6,30}$/i',
                Rule::unique('korisnik', 'username')->ignore($id,'idKorisnik'),
            ],
            'lozinka'=>'nullable|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/i',
        ];
    }

    public function messages()
    {
        return [
            'email.required'=>"Email je obavezan",
            'email.email'=>"Email nije u odgovarajućem formnatu",
            'email.unique'=>"Ovaj email se već koristi u sistemu",
            'username.required'=>"Korisničko ime je obavezan",
            'username.regex'=>"Korisničko ime nije u odgovarajućem formnatu",
            'username.unique'=>"Ovo korisničko ime se već koristi u sistemu",
            'lozinka.regex'=>"Lozinka nije u odgovarajućem formatu",
        ];
    }
}
