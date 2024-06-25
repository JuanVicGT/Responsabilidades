<?php

namespace App\Livewire\Backend\Responsability;

use Livewire\Component;

class ResponsabilitySheetCreate extends Component
{
    public $step = 1;

    public function render()
    {
        return view('livewire.backend.responsability.responsability-sheet-create');
    }

    public function nextStep()
    {
        $this->step++;
    }

    public function save()
    {
        $this->step = 1;
    }
}
