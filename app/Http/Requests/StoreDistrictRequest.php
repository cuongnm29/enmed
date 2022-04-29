<?php

namespace App\Http\Requests;

use App\District;
use Illuminate\Foundation\Http\FormRequest;

class StoreDistrictRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('district_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'countryid' => [
                'required',
            ],
            'citiesid' => [
                'required',
            ],
        ];
    }
}
