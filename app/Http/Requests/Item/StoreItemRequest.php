<?php

namespace App\Http\Requests\Item;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItemRequest extends FormRequest
{
    /** @var string */
    private $modelName = 'item';

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
            'code' => ['required', 'string', 'max:30', Rule::unique(Item::class)],
            'name' => ['required', 'string', 'max:150'],
            'serial' => ['required', 'string', 'max:150'],
            'quantity' => ['required', 'integer'],
            'unit_value' => ['required', 'float'],
            'amount' => ['nullable', 'float'],
            'description' => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
        ];
    }
}
