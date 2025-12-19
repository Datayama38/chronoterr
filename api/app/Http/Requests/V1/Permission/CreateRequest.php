<?php
namespace App\Http\Requests\V1\Permission;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest {

	public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:permissions,slug'],
        ];
    }
}