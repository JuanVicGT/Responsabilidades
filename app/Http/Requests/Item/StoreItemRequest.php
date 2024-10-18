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
            'code' => ['required', 'string', 'max:150', Rule::unique(Item::class)],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_value' => ['required', 'numeric'],
            'amount' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
        ];
    }
}
