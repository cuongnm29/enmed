<?php

namespace App\Http\Requests;

use App\Agent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('agent_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            
            'latitude' => [
                'required',
            ],
            'longitude' => [
                'required',
            ],
        ];
    }
}
