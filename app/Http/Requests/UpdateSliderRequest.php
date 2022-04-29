<?php

namespace App\Http\Requests;

use App\Gallery;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('slider_edit');
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
