<?php

namespace App\Http\Requests;

use App\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassGetCityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'ids'   => 'required|array',
        ];
    }
}
