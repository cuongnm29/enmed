<?php

namespace App\Http\Requests;

use App\AgentProduct;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentProductRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('agentproduct_edit');
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
