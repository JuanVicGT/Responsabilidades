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

    public function calcTotals()
    {
        $total_items = 0;
        $total_cash_in = 0;
        $total_cash_out = 0;
        $total_balance = 0;

        foreach ($this->component->step2_lines as $line) {
            $total_items += $line['quantity'];
            $total_cash_in += $line['cash_in'];
            $total_cash_out += $line['cash_out'];
            $total_balance += $line['balance'];
        }

        $this->component->step3_total_items = $total_items;
        $this->component->step3_total_cash_in = $total_cash_in;
        $this->component->step3_total_cash_out = $total_cash_out;
        $this->component->step3_total_balance = $total_balance;
    }
}
