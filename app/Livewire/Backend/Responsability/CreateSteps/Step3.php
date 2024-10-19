<?php

namespace App\Livewire\Backend\Responsability\CreateSteps;

use App\Livewire\Backend\Responsability\ResponsabilitySheetCreate;
use App\Models\LineResponsabilitySheet;

class Step3
{
    private $component;

    public function __construct(ResponsabilitySheetCreate &$component)
    {
        $this->component = $component;
    }

    public function save()
    {
        
    }
}
