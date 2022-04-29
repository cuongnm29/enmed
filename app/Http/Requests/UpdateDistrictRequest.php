<?php

namespace App\Http\Requests;

use App\District;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDistrictRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('district_edit');
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
