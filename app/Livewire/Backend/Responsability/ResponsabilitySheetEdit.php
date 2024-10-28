<?php

namespace App\Livewire\Backend\Responsability;

use App\Models\Item;
use App\Models\LineResponsabilitySheet;
use App\Models\ResponsabilitySheet;
use App\Models\User;
use Livewire\Component;

use App\Utils\Enums\AlertTypeEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Http\Services\AppSettingService;
use Mary\Traits\Toast;
use App\Utils\Alerts;

use App\Utils\Enums\ResponsabilitySheetStatusEnum;
use App\Utils\Lib\Transfer;
use Illuminate\Support\Facades\DB;

class ResponsabilitySheetEdit extends Component
{
    use Toast; // Method to show messages to users
    use Alerts; // Custom alerts to manager internal messages

    protected $appSettings;

    /** === View Attributes === */
    public $option_users; // option list
    public $option_items; // option list

    public $item_headers; // Table item_headers

    public $isAvailable;

    public $show_form = false;
    public $show_create_btn = false;

    public bool $show_transfer_modal = false;

    /** === Form Attributes === */
    public $id;
    public $number;
    public $status;
    public $status_translate;

    public $responsible_id;
    public $responsible_name;

    public $created_at;
    public $created_by;
    public $created_name;

    public $updated_at;
    public $updated_by;
    public $updated_name;

    public $line_code;
    public $line_date;
    public $id_item;
    public $line_amount;
    public $line_quantity = 1;
    public $line_description;
    public $line_observation;

    public $total_items;
    public $total_cash_in;
    public $total_cash_out;
    public $total_balance;

    /** === Lines/Detail === */
    public $lines;

    /** === Tranfer Form Attributes === */
    public $transfer_second_method = false;
    public $transfer_responsible_id;
    public $transfer_lines = [];
    public $show_transfer_btn = false;

    public function render()
    {
        return view('livewire.backend.responsability.responsability-sheet-edit');
    }

    public function mount(int &$id)
    {
        $this->appSettings = app(AppSettingService::class);

        $sheet = ResponsabilitySheet::find($id);

        $this->id = $sheet->id;
        $this->number = $sheet->number;
        $this->total_balance = $sheet->balance;
        $this->total_cash_in = $sheet->cash_in;
        $this->total_cash_out = $sheet->cash_out;
        $this->created_at = date('d/m/Y H:i', strtotime($sheet->created_at));
        $this->created_by = $sheet->created_by;
        $this->updated_at = date('d/m/Y H:i', strtotime($sheet->updated_at));
        $this->updated_by = $sheet->updated_by;
        $this->responsible_id = $sheet->id_responsible;

        $this->status = $sheet->status;
        $this->status_translate = __(ucfirst($sheet->status ?? ''));

        $responsible = User::find($this->responsible_id);
        $this->responsible_name = $responsible->name;

        $creator = User::find($this->created_by);
        $this->created_name = $creator->name;

        $updator = User::find($this->updated_by);
        if ($updator) {
            $this->updated_name = $updator->name;
        }

        $this->lines = $this->getlines($sheet);
        $this->searchUsers();
        $this->searchItems();

        $this->item_headers = $this->getItemTableHeaders();

        $this->total_items = count($this->lines);

        // Valores por defecto
        $this->line_date = date('Y-m-d');
        $this->isAvailable = $this->getIsAvailable();
        $this->show_create_btn = $this->appSettings->get('show_create_btn');
        $this->transfer_second_method = $this->appSettings->get('second_transfer_method', false);
    }

    protected function getlines(&$sheet): array
    {
        $lines = [];

        /** @var LineResponsabilitySheet */
        foreach ($sheet->lines as $line) {
            $item = Item::find($line->id_item);

            $lines[] = [
                // Id
                'line_id' => $line->id,
                'item_id' => $item->id,

                // Line fields
                'order' => $line->order,
                'cash_in' => $line->cash_in,
                'cash_out' => $line->cash_out,
                'balance' => $line->balance,
                'observations' => $line->observations,
                'date' => $line->date,

                // Item fields
                'code' => $item->code,
                'description' => $item->description,
                'quantity' => $item->quantity,
            ];
        }

        return $lines;
    }

    public function searchUsers(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->responsible_id)->get();

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
        $selectedOption = Item::where('id', $this->id_item)->get();

        $this->option_items = Item::query()
            ->where('description', 'like', "%$value%")
            ->where('is_available', 1)
            ->take(15)
            ->orderBy('description', 'asc')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    public function getItemTableHeaders()
    {
        return [
            ['key' => 'order', 'label' => __('#'), 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'date', 'label' => __('Date')],
            ['key' => 'code', 'label' => __('Code')],
            ['key' => 'description', 'label' => __('Description')],
            ['key' => 'quantity', 'label' => __('Quantity')],
            ['key' => 'cash_in', 'label' => __('Cash in')],
            ['key' => 'cash_out', 'label' => __('Cash out')],
            ['key' => 'balance', 'label' => __('Balance')],
            ['key' => 'observations', 'label' => __('Observations')]
        ];
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

    public function getIsAvailable(): bool
    {
        if (empty($this->status) || $this->status === ResponsabilitySheetStatusEnum::Open->value) {
            return true;
        }

        return false;
    }

    private function saveExistLine(array &$customLine)
    {
        if (empty($customLine['line_id'])) {
            return;
        }

        $line = LineResponsabilitySheet::find($customLine['line_id']);

        $line->update([
            'date' => $customLine['date'],
            'order' => $customLine['order'],
            'id_item' => $customLine['item_id'],
            'balance' => $customLine['balance'],
            'cash_in' => $customLine['cash_in'],
            'cash_out' => $customLine['cash_out'],
            'observations' => $customLine['observations'],
            'updated_by' => Auth::user()->id
        ]);
    }

    private function saveNewLine(array &$customLine, ResponsabilitySheet &$sheet)
    {
        $line = LineResponsabilitySheet::create([
            'id_sheet' => $sheet->id,
            'date' => $customLine['date'],
            'id_item' => $customLine['item_id'],
            'order' => $customLine['order'],
            'balance' => $customLine['balance'],
            'cash_in' => $customLine['cash_in'],
            'cash_out' => $customLine['cash_out'],
            'observations' => $customLine['observations'],
            'created_by' => Auth::user()->id
        ]);

        if (!$line) {
            $this->addAlert(AlertTypeEnum::Error, __('Line could not be created', ['code' => $customLine['code']]));
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

    public function save(): void
    {
        DB::beginTransaction();

        $responsabilitySheet = ResponsabilitySheet::find($this->id);

        $responsabilitySheet->update([
            'number' => $this->number,
            'id_responsible' => $this->responsible_id,
            'balance' => $this->total_balance,
            'cash_in' => $this->total_cash_in,
            'cash_out' => $this->total_cash_out,
            'updated_by' => Auth::user()->id,
            'status' => ResponsabilitySheetStatusEnum::Open->value
        ]);

        // Ahora se recorren las nuevas líneas
        foreach ($this->lines as $CustomLine) {
            // Si posee ID, es una actualización
            if (!empty($CustomLine['line_id'])) {
                $this->saveExistLine($CustomLine);
            }

            // Si no posee ID, es una nueva
            if (empty($CustomLine['line_id'])) {
                $this->saveNewLine($CustomLine, $responsabilitySheet);
            }
        }

        $this->addAlert(AlertTypeEnum::Success, __('Sheet updated successfully'));
        DB::commit();
        redirect()->route('responsability-sheet.edit', $responsabilitySheet->id)->with('alerts', $this->getAlerts());
    }

    public function blockSheet()
    {
        if (!$this->getIsAvailable()) {
            $this->addAlert(AlertTypeEnum::Warning, __('Sheet already closed'));
            $this->processAlerts();
            return;
        }

        $sheet = ResponsabilitySheet::find($this->id);
        $sheet->update([
            'status' => ResponsabilitySheetStatusEnum::Closed->value,
            'approved_by' => Auth::user()->id
        ]);

        $this->addAlert(AlertTypeEnum::Success, __('Sheet updated successfully'));
        redirect()->route('responsability-sheet.edit', $sheet->id)->with('alerts', $this->getAlerts());
    }

    public function duplicateLine(?int $item_id): bool
    {
        foreach ($this->lines as $line) {
            if ($line['item_id'] === $item_id) {
                $this->addAlert(AlertTypeEnum::Warning, __('Line already added'));
                return true;
            }
        }

        return false;
    }

    public  function loadItem(): bool
    {
        $item_id = $this->id_item;
        $item = Item::find($item_id);
        if (empty($item->id)) {
            $this->show_form = false;
            $this->addAlert(AlertTypeEnum::Error, __('Item not found'));
            return false;
        }

        $this->show_form = true;

        $this->line_code = $item->code;
        $this->line_quantity = $item->quantity;
        $this->line_description = $item->description;
        $this->line_observation = $item->observations;
        $this->line_amount = $item->amount;
        return true;
    }

    protected function updateItem(Item $item, array $data): bool
    {
        $update = false;

        if ($item->code !== $data['code'] && !empty($data['code'])) {
            $item->code = $data['code'];
            $update = true;
        }

        if ($item->quantity !== $data['quantity'] && !empty($data['quantity'])) {
            $item->quantity = $data['quantity'];

            $item->unit_value = $data['amount'] / $data['quantity'];
            $update = true;
        }

        if ($item->description !== $data['description'] && !empty($data['description'])) {
            $item->description = $data['description'];
            $update = true;
        }

        if ($item->observations !== $data['observations'] && !empty($data['observations'])) {
            $item->observations = $data['observations'];
            $update = true;
        }

        if ((float) $item->amount !== (float) $data['amount'] && !empty($data['amount'])) {
            $item->amount = $data['amount'];

            $item->unit_value = $data['amount'] / $data['quantity'];
            $update = true;
        }

        if ($update) {
            $item->save();
            return true;
        }

        return $update;
    }

    public function addLine(): bool
    {
        $alreadyAdded = $this->duplicateLine($this->id_item);
        if ($alreadyAdded) {
            $this->processAlerts();
            return false;
        }

        $item_id = $this->id_item;
        $item = Item::find($item_id);

        /** @var User */
        $user = Auth::user();
        $havePermissionToEditItem = $user->can('edit_item') || $user->is_admin;
        $havePermissionToCreateItem = $user->can('create_item') || $user->is_admin;
        if (empty($item->id) && !$havePermissionToCreateItem) {
            $this->addAlert(AlertTypeEnum::Error, __('Item not found'));
            return false;
        }

        $date = $this->line_date;
        $observations = $this->line_observation;

        $newItem = false;
        $updatedItem = false;
        if (empty($item) || empty($item->id)) {
            $this->validateInsert();

            $newItem = true;

            $code = $this->line_code;
            $amount = $this->line_amount;
            $quantity = $this->line_quantity;
            $description = $this->line_description;

            $item = Item::create([
                'code' => $code,
                'amount' => $amount,
                'quantity' => $quantity,
                'unit_value' => $amount / $quantity,
                'description' => $description,
                'observations' => $observations
            ]);

            if (empty($item->id)) {
                $this->addAlert(AlertTypeEnum::Error, __('Item not created'));
                return false;
            }
        }

        if (!empty($item->id) && $havePermissionToEditItem && !$newItem) {
            $this->validateUpdate();

            $code = $this->line_code;
            $amount = $this->line_amount;
            $quantity = $this->line_quantity;
            $description = $this->line_description;

            $updatedItem = $this->updateItem($item, [
                'code' => $code,
                'amount' => $amount,
                'quantity' => $quantity,
                'description' => $description,
                'observations' => $observations
            ]);
        }

        $observations = ($observations !== $item->observations && !empty($observations)) ? $observations : $item->observations;

        $balance = $item->amount;
        if (!empty($this->lines)) {
            $lat_key = array_key_last($this->lines);
            $balance = $this->lines[$lat_key]['balance'];

            $balance += $item->amount;
        }

        $line = [
            'item_id' => $item->id,
            'date' => $date,
            'code' => $item->code,
            'description' => $item->description,
            'quantity' => $item->quantity,
            'cash_in' => $item->amount,
            'cash_out' => 0,
            'balance' => $balance,
            'observations' => $observations,
            'order' => count($this->lines) + 1
        ];

        // Se limpian los campos
        $this->id_item = null;
        $this->line_code = null;
        $this->line_quantity = null;
        $this->line_description = null;
        $this->line_amount = null;
        $this->line_observation = null;

        $this->lines[] = $line;
        if ($newItem) {
            $this->addAlert(AlertTypeEnum::Success, __('Item created and added'));
        }

        if ($updatedItem) {
            $this->addAlert(AlertTypeEnum::Success, __('Item updated and added'));
        }

        if (!$newItem && !$updatedItem) {
            $this->addAlert(AlertTypeEnum::Success, __('Item added'));
        }

        $this->show_form = false;
        $this->calcTotals();

        $this->processAlerts();
        return true;
    }

    public function removeLine(int $item_id): bool
    {
        $lines = [];
        foreach ($this->lines as $line) {
            // Si no coincide el ID, vamos a seguir
            if ($line['item_id'] !== $item_id) {
                $lines[] = $line;
                continue;
            }

            $lineResponsabilitySheet = LineResponsabilitySheet::where('id_sheet', $this->id)
                ->where('id_item', $item_id)
                ->first();

            if ($lineResponsabilitySheet) {
                $lineResponsabilitySheet->delete();
            }

            $item = Item::find($item_id);
            $item->is_available = true;
            $item->save();

            $this->addAlert(AlertTypeEnum::Success, __('Line removed'));
        }
        $this->lines = $lines;

        $this->calcTotals();
        $this->processAlerts();
        return true;
    }

    public function changeAmountColumn(int $index)
    {
        $line = $this->lines[$index];

        $cash_in = $line['cash_out'];
        $cash_out = $line['cash_in'];

        $line['cash_in'] = $cash_in;
        $line['cash_out'] = $cash_out;

        $this->lines[$index] = $line;

        $this->recalculateBalance();
        $this->calcTotals();
    }

    public function recalculateBalance()
    {
        $balance = 0;

        foreach ($this->lines as $key => $line) {
            $balance += $line['cash_in'] - $line['cash_out'];

            $this->lines[$key]['balance'] = $balance;
        }
    }

    public function calcTotals()
    {
        $total_items = 0;
        $total_cash_in = 0;
        $total_cash_out = 0;
        $total_balance = 0;

        foreach ($this->lines as $line) {
            $total_items += $line['quantity'];
            $total_cash_in += $line['cash_in'];
            $total_cash_out += $line['cash_out'];
            $total_balance += $line['balance'];
        }

        $this->total_items = $total_items;
        $this->total_cash_in = $total_cash_in;
        $this->total_cash_out = $total_cash_out;
        $this->total_balance = $total_balance;
    }

    public function updateTransferLine($line_id, $is_checked)
    {
        if ($is_checked) {
            $this->transfer_lines[$line_id] = $line_id;
        }

        if (!$is_checked && isset($this->transfer_lines[$line_id])) {
            unset($this->transfer_lines[$line_id]);
        }

        if (!empty($this->transfer_lines)) {
            $this->show_transfer_btn = true;
        }
    }

    function makeTransfer()
    {
        if (empty($this->transfer_lines)) {
            $this->show_transfer_modal = false;
            $this->addAlert(AlertTypeEnum::Warning, __('No lines selected'));
            $this->processAlerts();
            return;
        }

        if (empty($this->transfer_responsible_id)) {
            $this->show_transfer_modal = false;
            $this->addAlert(AlertTypeEnum::Warning, __('No responsible selected'));
            $this->processAlerts();
            return;
        }

        $transfer = new Transfer();

        $transfer->setCurrentSheetId($this->id);
        $transfer->setItemsToTransfer($this->transfer_lines);
        $transfer->setNewResponsibleId($this->transfer_responsible_id);

        if ($this->transfer_second_method) {
            $transfer->useSecondMethod();
        }

        $response = $transfer->makeTransfer();

        // Validación de la respuesta
        if (!$response['status']) {
            $this->show_transfer_modal = false;

            if (isset($response['message'])) {
                $this->addAlert(AlertTypeEnum::Error, __($response['message']));
            } else {
                $this->addAlert(AlertTypeEnum::Error, __('Transfer could not be created'));
            }

            $this->processAlerts();
            return;
        }

        $this->show_transfer_modal = false;

        if (isset($response['message'])) {
            $this->addAlert(AlertTypeEnum::Success, __($response['message']));
        } else {
            $this->addAlert(AlertTypeEnum::Success, __('Transfer successfully created'));
        }

        return redirect()->route('responsability-sheet.edit', $this->id)->with('alerts', $this->getAlerts());
    }

    private function validateResponsable()
    {
        // Lógica de validación del paso 1
        $this->validate([
            'number' => ['required', 'string', 'max:150'],
            'responsible_id' => ['required'],
        ], [
            'number.required' => __('validation.required', ['attribute' => __('Number')]),
            'responsible_id.required' => __('validation.required', ['attribute' => __('Responsible')]),
        ]);
    }

    private function validateInsert()
    {
        // Lógica de validación del paso 1
        $this->validate([
            'line_code' => ['required', 'string', Rule::unique(Item::class, 'code')],
            'line_quantity' => ['required', 'integer'],
            'line_description' => ['required', 'string'],
            'line_amount' => ['required', 'numeric'],
            'line_observation' => ['required', 'string'],
            'line_date' => ['required'],
        ], [
            'line_code.required' => __('validation.required', ['attribute' => __('Code')]),
            'line_quantity.required' => __('validation.required', ['attribute' => __('Quantity')]),
            'line_description.required' => __('validation.required', ['attribute' => __('Description')]),
            'line_amount.required' => __('validation.required', ['attribute' => __('Amount')]),
            'line_observation.required' => __('validation.required', ['attribute' => __('Observations')]),
            'line_date.required' => __('validation.required', ['attribute' => __('Date')]),
        ]);
    }

    private function validateUpdate()
    {
        // Lógica de validación del paso 1
        $this->validate([
            'id_item' => ['required', 'integer', Rule::unique(Item::class, 'code')->ignore($this->id_item)],
            'line_code' => ['required', 'string'],
            'line_quantity' => ['required', 'integer'],
            'line_description' => ['required', 'string'],
            'line_amount' => ['required', 'numeric'],
            'line_observation' => ['required', 'string'],
            'line_date' => ['required'],
        ], [
            'id_item.required' => __('validation.required', ['attribute' => __('Item')]),
            'line_code.required' => __('validation.required', ['attribute' => __('Code')]),
            'line_quantity.required' => __('validation.required', ['attribute' => __('Quantity')]),
            'line_description.required' => __('validation.required', ['attribute' => __('Description')]),
            'line_amount.required' => __('validation.required', ['attribute' => __('Amount')]),
            'line_observation.required' => __('validation.required', ['attribute' => __('Observations')]),
            'line_date.required' => __('validation.required', ['attribute' => __('Date')]),
        ]);
    }
}
