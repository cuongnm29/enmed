<?php

namespace App\Http\Requests;

use App\Contact;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyContactRequest extends FormRequest
{
    public function authorize()
    {
        return abort_if(Gate::denies('contact_delete'), 403, '403 Forbidden') ?? true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categories,id',
        ];
    }
}
