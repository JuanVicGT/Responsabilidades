<?php

namespace App\Livewire\Public\Consult;

use Livewire\Component;

class ConsultSheet extends Component
{
    public $sheet;

    public $item_headers;

    public function mount($sheet)
    {
        $this->sheet = $sheet;

        $this->item_headers = [
            ['key' => 'order', 'label' => __('#'), 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'date', 'label' => __('Date')],
            ['key' => 'code', 'label' => __('Code')],
            ['key' => 'description', 'label' => __('Description')],
            ['key' => 'quantity', 'label' => __('Quantity')],
            ['key' => 'cash_in', 'label' => __('Cash in')],
            ['key' => 'cash_out', 'label' => __('Cash out')],
            ['key' => 'balance', 'label' => __('Balance')],
            ['key' => 'observations', 'label' => __('Observations')],
        ];
    }

    public function render()
    {
        return view('livewire.public.consult.consult-sheet');
    }
}
