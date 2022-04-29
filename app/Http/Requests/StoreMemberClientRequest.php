<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberClientRequest   extends FormRequest
{
    
    public function rules()
    {
        return [
            'username' => [
                'required',
            ],
            'password' => [
                'required',
            ],
            'countryid' => [
                'required',
            ],
            'citiesid' => [
                'required',
            ],
        ];
    }
}
