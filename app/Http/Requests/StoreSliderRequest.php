<?php

namespace App\Http\Requests;

use App\Slider;
use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('slider_create');
    }

    public function rules()
    {
        return [
            'image' => [
                'required',
            ],
        ];
    }
}
