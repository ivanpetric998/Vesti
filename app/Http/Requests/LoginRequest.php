<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username'=>'required|regex:/^[\d\w\_\-\.\@]{6,30}$/i|exists:korisnik,username',
            'password'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required'=>'Korisničko ime je obavezno',
            'username.regex'=>'Korisničko ime nije u dobrom formatu',
            'username.exists'=>'Ovo korisničko ime ne psotoji u sistemu',
            'password.required'=>'Lozinka je obavezna',
        ];
    }
}
