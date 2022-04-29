<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('setting_create');
    }

    public function rules()
    {
        return [
            'companyName'         => [
                'required',
            ],
            'email'         => [
                'required',
            ],
            'tel'         => [
                'required',
            ],
            'footer'         => [
                'required',
            ],
        ];
    }
}
