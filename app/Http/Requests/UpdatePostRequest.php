<?php

namespace App\Http\Requests;

use App\Post;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('post_edit');
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
