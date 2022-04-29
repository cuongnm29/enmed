<?php

namespace App\Http\Requests;

use App\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyPostRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('post_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:post,id',
        ];
    }
}
