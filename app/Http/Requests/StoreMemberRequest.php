<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest  extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('member_create');
    }

    public function rules()
    {
        return [
            'username' => [
                'required',
            ],
            'password' => [
                'required',
            ],
            
        ];
    }
}
