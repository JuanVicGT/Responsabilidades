<?php

namespace App\Http\Requests\Item;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    /** @var string */
    private $modelName = 'item';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'id' => ['required', 'integer'],
            'code' => ['required', 'string', 'max:30', Rule::unique(Item::class)->ignore($this->request->get('id'))],
            'name' => ['required', 'string', 'max:150'],
            'serial' => ['required', 'string', 'max:150'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_value' => ['required', 'string'],
            'amount' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
        ];
    }
}
