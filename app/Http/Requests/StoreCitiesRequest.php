<?php

namespace App\Http\Requests;

use App\City;
use Illuminate\Foundation\Http\FormRequest;

class StoreCitiesRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('cities_create');
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
