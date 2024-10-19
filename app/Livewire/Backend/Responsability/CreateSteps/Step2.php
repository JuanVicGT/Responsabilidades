<?php

namespace App\Livewire\Backend\Responsability\CreateSteps;

use App\Livewire\Backend\Responsability\ResponsabilitySheetCreate;
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

    public function add_line()
    {
        $line = new LineResponsabilitySheet();

        $this->component->lines[] = $line;
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
