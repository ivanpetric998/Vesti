<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVestRequest extends FormRequest
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
            'naslov'=>'required',
            'slika'=>'nullable|image|max:8000',
            'idKategorija'=>'exists:kategorija,idKategorija',
            'tagovi'=>'nullable',
            'naslovna'=>'nullable',
            'tekst'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'naslov.required'=>'Naslov teksa je obavezan',
            'slika.image'=>'Fajl mora da bude slika',
            'slika.max'=>'Slika ne sme da bude veća od 8000 kb',
            'idKategorija.exists'=>'Morate izabrati kategoriju',
            'tekst.required'=>'Tekst je obavezan',
        ];
    }
}
