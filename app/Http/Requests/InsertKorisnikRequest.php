<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertKorisnikRequest extends FormRequest
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
            'email'=>'required|email|unique:korisnik,email',
            'username'=>'required|regex:/^[\d\w\_\-\.\@]{6,30}$/i|unique:korisnik,username',
            'lozinka'=>'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/i',
            'uloga'=>'required|exists:uloga,idUloga',
            'aktivan'=>'nullable',
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
          'lozinka.required'=>"Lozinka je obavezna",
          'lozinka.regex'=>"Lozinka nije u odgovarajućem formatu",
          'uloga.required'=>'Uloga je obavezna',
          'uloga.exists'=>'Uloga ne postoji u sistemu',
        ];
    }
}
