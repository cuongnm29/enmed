<?php

namespace App\Http\Requests;

use App\Agent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyAgentRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('agent_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categories,id',
        ];
    }
}
