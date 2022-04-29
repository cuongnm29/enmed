<?php

namespace App\Http\Requests;

use App\Countries;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCountriesRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('countries_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
           
        ];
    }
}
