<?php

namespace App\Http\Requests;

use App\Agent;
use Illuminate\Foundation\Http\FormRequest;

class StoreAgentRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('agent_create');
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
