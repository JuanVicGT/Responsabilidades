<?php

namespace App\Livewire\Backend\Responsability;

use App\Models\User;
use Livewire\Component;

class ResponsabilitySheetCreate extends Component
{
    /** === View Attributes === */
    public $step; // show sections
    public $users; // option list

    /** === Form Attributes === */
    public $id_responsible;
    public $series;
    public $money;

    public function mount()
    {
        $this->step = 1;
        $this->money = 54000.12;

        $this->search();
    }

    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->id_responsible)->get();

        $this->users = User::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    public function render()
    {
        return view('livewire.backend.responsability.responsability-sheet-create');
    }

    public function nextStep()
    {
        if ($this->step === 1)
            return $this->finishStep1();

        if ($this->step === 2)
            return $this->finishStep2();

        $this->step++;
    }

    public function save()
    {
        $this->step = 1;
    }

    protected function finishStep1()
    {
        $this->validateStep1();
        $this->step = 2;
    }

    protected function validateStep1()
    {
        $this->validate([
            'series' => 'starts_with:Hello|ends_with:world',
        ]);
    }

    protected function finishStep2()
    {
        $this->step = 3;
    }
}
