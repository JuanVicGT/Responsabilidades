<?php

namespace App\Livewire\Backend\Responsability;

use App\Livewire\Backend\Responsability\CreateSteps\Step1;
use App\Livewire\Backend\Responsability\CreateSteps\Step2;
use App\Livewire\Backend\Responsability\CreateSteps\Step3;
use App\Models\LineResponsabilitySheet;
use App\Models\User;
use Livewire\Component;

class ResponsabilitySheetCreate extends Component
{
    /** === Form Attributes === */
    protected Step1 $step1;
    protected Step2 $step2;
    protected Step3 $step3;

    /** === View Attributes === */
    public $current_step; // Show sections
    public $users; // option list

    /** === Form Attributes === */
    public $form_id_responsible;
    public $form_number;
    public $form_total;

    public $form_id_line;
    public $form_custom_line_amount;
    public $form_custom_line_description;

    /** @var LineResponsabilitySheet[] */
    public $lines;

    public function __construct()
    {
        $this->step1 = new Step1($this);
        $this->step2 = new Step2($this);
        $this->step3 = new Step3($this);
    }

    public function mount()
    {
        // Se instancian los pasos
        $this->current_step = 1;
        $this->lines = [];

        $this->search();
    }

    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->form_id_responsible)->get();

        $this->users = User::query()
            ->where('name', 'like', "%$value%")
            ->take(15)
            ->orderBy('name', 'asc')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    public function render()
    {
        return view('livewire.backend.responsability.responsability-sheet-create');
    }

    public function nextStep()
    {
        if ($this->current_step === 1)
            return $this->step1->finish();

        if ($this->current_step === 2)
            return $this->step2->finish();
    }



    public function save()
    {
        $this->step3->save();
    }
}
