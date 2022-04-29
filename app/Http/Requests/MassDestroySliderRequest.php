<?php

namespace App\Http\Requests;

use App\Slider;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroySliderRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('slider_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categories,id',
        ];
    }
}
