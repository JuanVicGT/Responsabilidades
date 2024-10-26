<?php

namespace App\Livewire\Backend\Responsability\CreateSteps;

use App\Livewire\Backend\Responsability\ResponsabilitySheetCreate;
use App\Models\Item;
use App\Models\LineResponsabilitySheet;
use App\Utils\Enums\AlertTypeEnum;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Step2
{
    private $component;

    public function __construct(ResponsabilitySheetCreate $component)
    {
        $this->component = $component;
    }

    public function getItemTableHeaders()
    {
        return [
            ['key' => 'order', 'label' => __('#'), 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'date', 'label' => __('Date')],
            ['key' => 'code', 'label' => __('Code')],
            ['key' => 'description', 'label' => __('Description')],
            ['key' => 'quantity', 'label' => __('Quantity')],
            ['key' => 'cash_in', 'label' => __('Cash in')],
            ['key' => 'cash_out', 'label' => __('Cash out')],
            ['key' => 'balance', 'label' => __('Balance')],
            ['key' => 'observations', 'label' => __('Observations')]
        ];
    }

    public function finish()
    {
        $this->component->current_step++;
    }

    public function duplicateLine(?int $item_id): bool
    {
        foreach ($this->component->step2_lines as $line) {
            if ($line['item_id'] === $item_id) {
                $this->component->addAlert(AlertTypeEnum::Warning, __('Line already added'));
                return true;
            }
        }

        return false;
    }

    public  function loadItem($item_id): bool
    {
        $item = Item::find($item_id);
        if (empty($item->id)) {
            $this->component->addAlert(AlertTypeEnum::Error, __('Item not found'));
            return false;
        }

        $this->component->form_step2_code = $item->code;
        $this->component->form_step2_line_quantity = $item->quantity;
        $this->component->form_step2_line_description = $item->description;
        $this->component->form_step2_line_observation = $item->observations;
        $this->component->form_step2_line_amount = $item->amount;
        return true;
    }

    protected function updateItem(Item $item, array $data): bool
    {
        $update = false;

        if ($item->code !== $data['code'] && !empty($data['code'])) {
            $item->code = $data['code'];
            $update = true;
        }

        if ($item->quantity !== $data['quantity'] && !empty($data['quantity'])) {
            $item->quantity = $data['quantity'];

            $item->unit_value = $data['amount'] / $data['quantity'];
            $update = true;
        }

        if ($item->description !== $data['description'] && !empty($data['description'])) {
            $item->description = $data['description'];
            $update = true;
        }

        if ($item->observations !== $data['observations'] && !empty($data['observations'])) {
            $item->observations = $data['observations'];
            $update = true;
        }

        if ((float) $item->amount !== (float) $data['amount'] && !empty($data['amount'])) {
            $item->amount = $data['amount'];

            $item->unit_value = $data['amount'] / $data['quantity'];
            $update = true;
        }

        if ($update) {
            $item->save();
            return true;
        }

        return $update;
    }

    public function addLine(): bool
    {
        $item_id = $this->component->form_step2_id_item;
        $item = Item::find($item_id);

        /** @var User */
        $user = Auth::user();
        $havePermissionToEditItem = $user->can('edit_item') || $user->is_admin;
        $havePermissionToCreateItem = $user->can('create_item') || $user->is_admin;
        if (empty($item->id) && !$havePermissionToCreateItem) {
            $this->component->addAlert(AlertTypeEnum::Error, __('Item not found'));
            return false;
        }

        $date = $this->component->form_step2_date;
        $observations = $this->component->form_step2_line_observation;

        $newItem = false;
        $updatedItem = false;
        if (empty($item->id)) {
            $this->validateInsert();

            $newItem = true;

            $code = $this->component->form_step2_code;
            $amount = $this->component->form_step2_line_amount;
            $quantity = $this->component->form_step2_line_quantity;
            $description = $this->component->form_step2_line_description;

            $item = Item::create([
                'code' => $code,
                'amount' => $amount,
                'quantity' => $quantity,
                'unit_value' => $amount / $quantity,
                'description' => $description,
                'observations' => $observations
            ]);

            if (empty($item->id)) {
                $this->component->addAlert(AlertTypeEnum::Error, __('Item not created'));
                return false;
            }
        }

        if (!empty($item->id) && $havePermissionToEditItem && !$newItem) {
            $this->validateUpdate();

            $code = $this->component->form_step2_code;
            $amount = $this->component->form_step2_line_amount;
            $quantity = $this->component->form_step2_line_quantity;
            $description = $this->component->form_step2_line_description;

            $updatedItem = $this->updateItem($item, [
                'code' => $code,
                'amount' => $amount,
                'quantity' => $quantity,
                'description' => $description,
                'observations' => $observations
            ]);
        }

        $observations = ($observations !== $item->observations && !empty($observations)) ? $observations : $item->observations;

        $balance = $item->amount;
        if (!empty($this->component->step2_lines)) {
            $lat_key = array_key_last($this->component->step2_lines);
            $balance = $this->component->step2_lines[$lat_key]['balance'];

            $balance += $item->amount;
        }

        $line = [
            'item_id' => $item->id,
            'date' => $date,
            'code' => $item->code,
            'description' => $item->description,
            'quantity' => $item->quantity,
            'cash_in' => $item->amount,
            'cash_out' => 0,
            'balance' => $balance,
            'observations' => $observations,
            'order' => count($this->component->step2_lines) + 1
        ];

        // Se limpian los campos
        $this->component->form_step2_id_item = null;
        $this->component->form_step2_code = null;
        $this->component->form_step2_line_quantity = null;
        $this->component->form_step2_line_description = null;
        $this->component->form_step2_line_amount = null;
        $this->component->form_step2_line_observation = null;

        $this->component->step2_lines[] = $line;
        if ($newItem) {
            $this->component->addAlert(AlertTypeEnum::Success, __('Item created and added'));
        }

        if ($updatedItem) {
            $this->component->addAlert(AlertTypeEnum::Success, __('Item updated and added'));
        }

        if (!$newItem && !$updatedItem) {
            $this->component->addAlert(AlertTypeEnum::Success, __('Item added'));
        }

        return true;
    }

    public function removeLine(int $item_id): bool
    {
        $lines = [];
        foreach ($this->component->step2_lines as $line) {
            if ($line['item_id'] === $item_id) {
                $this->component->addAlert(AlertTypeEnum::Success, __('Line removed'));
                continue;
            }

            $lines[] = $line;
        }
        $this->component->step2_lines = $lines;

        return true;
    }

    private function validateInsert()
    {
        // Lógica de validación del paso 1
        $this->component->validate([
            'form_step2_code' => ['required', 'string', Rule::unique(Item::class, 'code')],
            'form_step2_line_quantity' => ['required', 'integer'],
            'form_step2_line_description' => ['required', 'string'],
            'form_step2_line_amount' => ['required', 'numeric'],
            'form_step2_line_observation' => ['required', 'string'],
        ], [
            'form_step2_code.required' => __('validation.required', ['attribute' => __('Code')]),
            'form_step2_line_quantity.required' => __('validation.required', ['attribute' => __('Quantity')]),
            'form_step2_line_description.required' => __('validation.required', ['attribute' => __('Description')]),
            'form_step2_line_amount.required' => __('validation.required', ['attribute' => __('Amount')]),
            'form_step2_line_observation.required' => __('validation.required', ['attribute' => __('Observations')]),
        ]);
    }

    private function validateUpdate()
    {
        // Lógica de validación del paso 1
        $this->component->validate([
            'form_step2_id_item' => ['required', 'integer', Rule::unique(Item::class, 'code')->ignore($this->component->form_step2_id_item)],
            'form_step2_code' => ['required', 'string'],
            'form_step2_line_quantity' => ['required', 'integer'],
            'form_step2_line_description' => ['required', 'string'],
            'form_step2_line_amount' => ['required', 'numeric'],
            'form_step2_line_observation' => ['required', 'string'],
        ], [
            'form_step2_id_item.required' => __('validation.required', ['attribute' => __('Item')]),
            'form_step2_code.required' => __('validation.required', ['attribute' => __('Code')]),
            'form_step2_line_quantity.required' => __('validation.required', ['attribute' => __('Quantity')]),
            'form_step2_line_description.required' => __('validation.required', ['attribute' => __('Description')]),
            'form_step2_line_amount.required' => __('validation.required', ['attribute' => __('Amount')]),
            'form_step2_line_observation.required' => __('validation.required', ['attribute' => __('Observations')]),
        ]);
    }
}
