<?php

namespace App\Livewire\Backend\Responsability;

use Mary\Traits\Toast;
use App\Utils\Alerts;

use App\Models\Item;
use App\Models\LineResponsabilitySheet;
use App\Models\User;
use Livewire\Component;

use App\Livewire\Backend\Responsability\CreateSteps\Step1;
use App\Livewire\Backend\Responsability\CreateSteps\Step2;
use App\Livewire\Backend\Responsability\CreateSteps\Step3;
use App\Utils\Enums\AlertTypeEnum;

use Illuminate\Support\Facades\Auth;

class ResponsabilitySheetCreate extends Component
{
    use Toast; // Method to show messages to users
    use Alerts; // Custom alerts to manager internal messages

    /** === Form Attributes === */
    protected Step1 $step1;
    protected Step2 $step2;
    protected Step3 $step3;

    /** === View Attributes === */
    public $current_step; // Show sections
    public $step1_option_users; // option list
    public $step2_option_items; // option list

    public $step2_table_item_headers; // Table headers

    /** === Form Attributes === */
    public $form_step1_id_responsible;
    public $form_step1_name_responsible;
    public $form_step1_number;

    public $form_step2_code;
    public $form_step2_date;
    public $form_step2_id_item;
    public $form_step2_line_amount;
    public $form_step2_line_quantity = 1;
    public $form_step2_line_description;
    public $form_step2_line_observation;

    public $form_step3_total;

    /** === Lines/Detail === */
    public $step2_lines;

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
        $this->step2_lines = [];
        $this->form_step2_date = date('Y-m-d');

        $this->step2_table_item_headers = $this->step2->getItemTableHeaders();

        $this->searchUsers();
        $this->searchItems();
    }

    public function searchUsers(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->form_step1_id_responsible)->get();

        $this->step1_option_users = User::query()
            ->where('name', 'like', "%$value%")
            ->take(15)
            ->orderBy('name', 'asc')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    public function searchItems(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Item::where('id', $this->form_step2_id_item)->get();

        $this->step2_option_items = Item::query()
            ->where('description', 'like', "%$value%")
            ->where('is_available', 1)
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

    protected function processAlerts()
    {
        /** @var array $alerts */
        foreach ($this->getAlertsArray() as $alert) {
            $type = $alert->type->value;
            $message = __("{$alert->message}");

            if ($type === AlertTypeEnum::Success->value) {
                $this->success($message, position: 'toast-top toast-center', timeout: 5000);
            }

            if ($type === AlertTypeEnum::Warning->value) {
                $this->warning($message, position: 'toast-top toast-center', timeout: 5000);
            }

            if ($type === AlertTypeEnum::Error->value) {
                $this->error($message, position: 'toast-top toast-center', timeout: 5000);
            }

            if ($type === AlertTypeEnum::Info->value) {
                $this->info($message, position: 'toast-top toast-center', timeout: 5000);
            }
        }

        $this->clearAlerts();
    }

    public function save()
    {
        $this->step3->save();
    }

    public function loadItem()
    {
        $this->step2->loadItem($this->form_step2_id_item);

        $this->processAlerts();
    }

    public function addLine()
    {
        $alreadyAdded = $this->step2->duplicateLine($this->form_step2_id_item);

        if ($alreadyAdded) {
            $this->processAlerts();
            return;
        }

        $this->step2->addLine();

        $this->processAlerts();
    }

    public function removeLine($item_id)
    {
        $this->step2->removeLine($item_id);

        $this->processAlerts();
    }
}
