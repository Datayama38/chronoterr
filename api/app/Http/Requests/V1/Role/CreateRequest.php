<?php

namespace App\Http\Requests\V1\Role;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }
}
