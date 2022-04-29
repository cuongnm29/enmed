<?php

namespace App\Http\Requests;
use App\MemberClient;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberClientRequest  extends FormRequest
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
            'fileupload' => [
                'required',
            ],
        ];
    }
}
