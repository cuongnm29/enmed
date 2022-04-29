<?php

namespace App\Http\Requests;

use App\Countries;
use Illuminate\Foundation\Http\FormRequest;

class StoreCountriesRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('countries_create');
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
