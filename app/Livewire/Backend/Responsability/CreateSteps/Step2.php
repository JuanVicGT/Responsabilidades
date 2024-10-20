<?php

namespace App\Livewire\Backend\Responsability\CreateSteps;

use App\Livewire\Backend\Responsability\ResponsabilitySheetCreate;
use App\Models\Item;
use App\Models\LineResponsabilitySheet;

class Step2
{
    private $component;

    public function __construct(ResponsabilitySheetCreate &$component)
    {
        $this->component = $component;
    }

    public function finish()
    {
        $this->component->current_step++;
    }

    public function addLine(int $item_id): bool
    {
        $item = Item::find($item_id);

        if (empty($item->id)) {
            return false;
        }

        $this->component->lines[] = $item;
        return true;
    }

    private function validate_line()
    {
        // Lógica de validación del paso 1
        $this->component->validate([
            'form_number' => ['required', 'string', 'max:150'],
            'form_id_responsible' => ['required'],
        ]);
    }
}
