<?php

namespace App\Http\Requests;

use App\District;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyDistrictRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('district_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categories,id',
        ];
    }
}
