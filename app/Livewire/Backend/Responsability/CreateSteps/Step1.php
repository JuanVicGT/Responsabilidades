<?php

namespace App\Livewire\Backend\Responsability\CreateSteps;

use App\Livewire\Backend\Responsability\ResponsabilitySheetCreate;
use App\Models\User;

class Step1
{
    private $component;

    public function __construct(ResponsabilitySheetCreate &$component)
    {
        $this->component = $component;
    }

    public function finish($validate = true)
    {
        if ($validate) {
            $this->validate();
        }

        $user = User::find($this->component->form_step1_id_responsible);
        $this->component->form_step1_name_responsible = $user->name;

        $this->component->current_step++;
    }

    private function validate()
    {
        // Lógica de validación del paso 1
        $this->component->validate([
            'form_step1_number' => ['required', 'string', 'max:150'],
            'form_step1_id_responsible' => ['required'],
        ], [
            'form_step1_number.required' => __('validation.required', ['attribute' => __('Number')]),
            'form_step1_id_responsible.required' => __('validation.required', ['attribute' => __('Responsible')]),
        ]);
    }
}
