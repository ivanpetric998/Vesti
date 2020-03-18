<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertUpdateTagRequest extends FormRequest
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
            'naziv'=>'required|regex:/^[A-zŠĐŽČĆđšćčž\d]{2,}(\s[A-zŠĐŽČĆđšćčž\d]{1,})*$/i'
        ];
    }

    public function messages()
    {
        return [
            'naziv.required'=>'Naziv taga je obavezan',
            'naziv.regex'=>'Naziv taga nije u dobrom formatu',
        ];
    }
}
