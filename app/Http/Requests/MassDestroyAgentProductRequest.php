<?php

namespace App\Http\Requests;

use App\AgentProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyAgentProductRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('agentproduct_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categories,id',
        ];
    }
}
