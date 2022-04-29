<?php

namespace App\Http\Requests;

use App\City;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCitiesRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('cities_edit');
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
        ];
    }
}
