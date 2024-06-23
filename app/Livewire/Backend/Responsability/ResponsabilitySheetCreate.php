<?php

namespace App\Livewire\Backend\Responsability;

use Livewire\Component;

class ResponsabilitySheetCreate extends Component
{
    public $step = 1;

    public $test_val;

    public function render()
    {
        return view('livewire.backend.responsability.responsability-sheet-create');
    }

    public function save()
    {
        $this->step = 1;
    }
}
