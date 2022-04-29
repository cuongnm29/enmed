<?php

namespace App\Http\Requests;

use App\Contact;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    

    public function rules()
    {
        return [
            'firstname' => [
                'required',
            ],
            'lastname' => [
                'required',
            ],
            'email' => [
                'required',
            ],
            'note' => [
                'required',
            ],
            
        ];
    }
}
