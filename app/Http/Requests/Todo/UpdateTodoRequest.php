<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{
    /** @var string */
    private $modelName = 'todo';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->request->get('id_user') !== (string) $this->user()->id)
            return false;

        return $this->user()->is_admin || $this->user()->hasPermissionTo('edit_' . $this->modelName);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'        => ['required', 'integer'],
            'id_user'   => ['required', 'integer'],
            'name'      => ['required', 'string', 'max:150'],
            'status'    => ['required', 'string', 'max:30'],
            'hour'      => ['nullable', 'date_format:H:i'],
            'date'      => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ];
    }
}
