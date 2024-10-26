<?php

namespace App\Livewire\Backend\Responsability;

use App\Http\Services\AppSettingService;
use Mary\Traits\Toast;
use App\Utils\Alerts;
use Livewire\Component;

use App\Models\Item;
use App\Models\User;
use App\Models\ResponsabilitySheet;
use App\Models\LineResponsabilitySheet;

use App\Utils\Enums\AlertTypeEnum;
use App\Livewire\Backend\Responsability\CreateSteps\Step1;
use App\Livewire\Backend\Responsability\CreateSteps\Step2;
use App\Livewire\Backend\Responsability\CreateSteps\Step3;
use App\Utils\Enums\ResponsabilitySheetStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResponsabilitySheetCreate extends Component
{
    use Toast; // Method to show messages to users
    use Alerts; // Custom alerts to manager internal messages

    protected $appSettings;

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

    public $step3_total_items;
    public $step3_total_cash_in;
    public $step3_total_cash_out;
    public $step3_total_balance;

    /** === Lines/Detail === */
    public $step2_lines;

    public function __construct()
    {
        $this->step1 = new Step1($this);
        $this->step2 = new Step2($this);
        $this->step3 = new Step3($this);

        $this->appSettings = app(AppSettingService::class);
    }

    public function mount()
    {
        $this->current_step = 1;

        $this->form_step1_number = (string) ResponsabilitySheet::getNextNumber();

        $this->step2_lines = [];
        $this->form_step2_date = date('Y-m-d');

        $this->step2_table_item_headers = $this->step2->getItemTableHeaders();

        // Carga inicial de opciones
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
        DB::beginTransaction();

        $responsabilitySheet = ResponsabilitySheet::create([
            'number' => $this->form_step1_number,
            'id_responsible' => $this->form_step1_id_responsible,
            'balance' => $this->step3_total_balance,
            'cash_in' => $this->step3_total_cash_in,
            'cash_out' => $this->step3_total_cash_out,
            'created_by' => Auth::user()->id,
            'status' => ResponsabilitySheetStatusEnum::Open->value
        ]);

        if (!$responsabilitySheet) {
            $this->addAlert(AlertTypeEnum::Error, __('Could not be created'));
            $this->processAlerts();
            DB::rollBack();
            return;
        }

        foreach ($this->step2_lines as $line) {
            $line = LineResponsabilitySheet::create([
                'id_sheet' => $responsabilitySheet->id,
                'date' => $line['date'],
                'id_item' => $line['item_id'],
                'order' => $line['order'],
                'balance' => $line['balance'],
                'cash_in' => $line['cash_in'],
                'cash_out' => $line['cash_out'],
                'observations' => $line['observations'],
                'created_by' => Auth::user()->id
            ]);

            if (!$line) {
                $this->addAlert(AlertTypeEnum::Error, __('Line could not be created', ['code' => $line['code']]));
                $this->processAlerts();
                DB::rollBack();
                return;
            }

            $item = Item::find($line['id_item']);
            $item->is_available = false;

            if (!$item->save()) {
                $this->addAlert(AlertTypeEnum::Error, __('Item could not be updated', ['code' => $line['code']]));
                $this->processAlerts();
                DB::rollBack();
                return;
            }
        }

        $this->addAlert(AlertTypeEnum::Success, __('Sheet created successfully'));
        DB::commit();
        return redirect()->route('responsability-sheet.edit', $responsabilitySheet->id)->with('alerts', $this->getAlerts());
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

        if ($this->step2->addLine()) {
            $this->step3->calcTotals();
        }

        $this->processAlerts();
    }

    public function removeLine($item_id)
    {
        if ($this->step2->removeLine($item_id)) {
            $this->step3->calcTotals();
        }

        $this->processAlerts();
    }

    public function changeAmountColumn(int $index)
    {
        $line = $this->step2_lines[$index];

        $cash_in = $line['cash_out'];
        $cash_out = $line['cash_in'];

        $line['cash_in'] = $cash_in;
        $line['cash_out'] = $cash_out;

        $this->step2_lines[$index] = $line;

        $this->recalculateBalance();
        $this->step3->calcTotals();
    }

    public function recalculateBalance()
    {
        $balance = 0;

        foreach ($this->step2_lines as $key => $line) {
            $balance += $line['cash_in'] - $line['cash_out'];

            $this->step2_lines[$key]['balance'] = $balance;
        }
    }
}
