<?php

namespace App\Livewire\Backend\Responsability;

use Mary\Traits\Toast;

use App\Models\Item;
use App\Models\LineResponsabilitySheet;
use App\Models\User;
use Livewire\Component;

use App\Livewire\Backend\Responsability\CreateSteps\Step1;
use App\Livewire\Backend\Responsability\CreateSteps\Step2;
use App\Livewire\Backend\Responsability\CreateSteps\Step3;

class ResponsabilitySheetCreate extends Component
{
    use Toast;

    /** === Form Attributes === */
    protected Step1 $step1;
    protected Step2 $step2;
    protected Step3 $step3;

    /** === View Attributes === */
    public $current_step; // Show sections
    public $option_users; // option list
    public $option_items; // option list

    public $table_item_headers; // Table headers

    /** === Form Attributes === */
    public $form_id_responsible;
    public $form_number;
    public $form_total;

    public $form_id_item;
    public $form_custom_line_amount;
    public $form_custom_line_description;

    /** @var Item[] */
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
        $this->current_step = 2;
        $this->lines = [];

        $this->table_item_headers = [
            ['key' => 'code', 'label' => __('Code')],
            ['key' => 'description', 'label' => __('Description')],
            ['key' => 'amount', 'label' => __('Amount')]
        ];

        $this->searchUsers();
        $this->searchItems();
    }

    public function searchUsers(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->form_id_responsible)->get();

        $this->option_users = User::query()
            ->where('name', 'like', "%$value%")
            ->take(15)
            ->orderBy('name', 'asc')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    public function searchItems(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Item::where('id', $this->form_id_item)->get();

        $this->option_items = Item::query()
            ->where('description', 'like', "%$value%")
            ->take(15)
            ->orderBy('description', 'asc')
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

    public function addLine()
    {
        $item_id = $this->form_id_item;
        if (empty($item_id)) {
            $this->warning(__('Please select an item'), position: 'toast-top toast-center', timeout: 5000);
            return;
        }

        if (!$this->step2->addLine($item_id)) {
            $this->warning(__('Item not found'), position: 'toast-top toast-center', timeout: 5000);
            return;
        }

        $this->success(__('Item added'), position: 'toast-top toast-center', timeout: 5000);

        // Se limpian los campos
        $this->form_id_item = null;
    }
}
