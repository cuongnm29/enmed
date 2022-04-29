<?php

namespace App\Http\Requests;

use App\Gallery;
use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
