<?php

namespace App\Http\Requests;

use App\AgentProduct;
use Illuminate\Foundation\Http\FormRequest;

class StoreAgentProductRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('agentproduct_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
          
            'catid' => [
                'required',
            ],
            'summary' => [
                'required',
            ],
            'content' => [
                'required',
            ],
            'image' => [
                'required',
            ],
        ];
    }
}
