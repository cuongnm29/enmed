<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('post_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
            ],
            
            'content' => [
                'required',
            ],
            
        ];
    }
}
