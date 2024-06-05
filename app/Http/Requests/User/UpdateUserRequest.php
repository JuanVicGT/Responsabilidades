<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /** @var string */
    private $modelName = 'user';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->is_admin || $this->user()->hasPermissionTo('create_' . $this->modelName);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required'],
            'code' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', Rule::unique('users', 'username')->ignore($this->request->get('id'))],
            'name' => ['required', 'string', 'max:150'],
            'last_name' => ['nullable', 'string', 'max:150'],
            'work_position' => ['nullable', 'string', 'max:50'],
            'work_row' => ['nullable', 'string', 'max:30'],
            'dependency' => ['nullable', 'string', 'max:30'],
            'role' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('users', 'email')->ignore($this->request->get('id'))],
            'birthdate' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:100'],
            'is_admin' => ['nullable', 'integer', 'between:0,1'],
            'is_active' => ['nullable', 'integer', 'between:0,1'],
        ];
    }
}
