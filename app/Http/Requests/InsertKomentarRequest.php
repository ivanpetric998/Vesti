<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertKomentarRequest extends FormRequest
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
            'tekst'=>'required',
            'korisnik'=>'exists:korisnik,idKorisnik',
            'vest'=>'exists:vest,idVest',
        ];
    }

    public function messages()
    {
        return [
            'tekst.required'=>'Tekst komentara je obavezan',
            'korisnik.exists'=>'Niste korisnik aplikacije',
            'vest.exists'=>'Vest ne postoji',
        ];
    }
}
