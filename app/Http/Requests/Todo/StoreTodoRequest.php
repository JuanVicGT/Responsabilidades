<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    /** @var string */
    private $modelName = 'todo';

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
            'name'      => ['required', 'string', 'max:150'],
            'status'    => ['required', 'string', 'max:30'],
            'hour'      => ['nullable', 'date_format:H:i'],
            'date'      => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ];
    }
}
