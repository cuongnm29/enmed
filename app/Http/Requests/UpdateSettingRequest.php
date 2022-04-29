<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('setting_edit');
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
