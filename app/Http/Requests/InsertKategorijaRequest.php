<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertKategorijaRequest extends FormRequest
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
            'naziv'=>'required|regex:/^[A-zŠĐŽČĆđšćčž\d]{1,}(\s[A-zŠĐŽČĆđšćčž\d]{1,})*$/i',
            'pozicija'=>'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'naziv.required'=>'Naziv kategorije je obavezan',
            'naziv.regex'=>'Naziv kategorije nije u dobrom formatu',
            'pozicija.required'=>'Pozicija je obavezna',
            'pozicija.regex'=>'Pozicija nije u dobrom formatu',
        ];
    }
}
