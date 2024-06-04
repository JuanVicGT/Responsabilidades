<?php

namespace App\Http\Requests\Dependency;

use App\Models\Dependency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDependencyRequest extends FormRequest
{
    /** @var string */
    private $modelName = 'dependency';

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
            'code' => ['required', 'string', 'max:30', Rule::unique(Dependency::class)],
            'name' => ['required', 'string', 'max:150'],
        ];
    }
}
