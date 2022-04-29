<?php

namespace App\Http\Requests;

use App\Countries;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyCountriesRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('countries_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categories,id',
        ];
    }
}
