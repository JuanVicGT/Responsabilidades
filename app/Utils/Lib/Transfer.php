<?php

namespace App\Utils\Lib;

use App\Models\LineResponsabilitySheet;
use App\Models\ResponsabilitySheet;
use App\Models\User;
use App\Utils\Enums\ResponsabilitySheetStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transfer
{
    // Use first or second method to transfer items
    protected string $method;

    protected int $current_sheet_id;

    protected int $new_responsible_id;
    protected array $lines_to_transfer = [];

    public function __construct()
    {
        $this->method = 'first';
    }

    public function useSecondMethod()
    {
        $this->method = 'second';
    }

    public function useFirstMethod()
    {
        $this->method = 'first';
    }

    public function setNewResponsibleId(int $new_responsible_id)
    {
        $this->new_responsible_id = $new_responsible_id;
    }

    public function setItemsToTransfer(array $lines_to_transfer)
    {
        $this->lines_to_transfer = $lines_to_transfer;
    }

    public function setCurrentSheetId(int $current_sheet_id)
    {
        $this->current_sheet_id = $current_sheet_id;
    }

    /**
     * Returns an array response with status and message
     * 
     * @param string $message
     * @param bool $status
     * @return array
     */
    protected function responseArray(string $message, bool $status = false): array
    {
        return [
            'status' => $status,
            'message' => $message
        ];
    }

    public function makeTransfer(): array
    {
        DB::beginTransaction();
        if ($this->method === 'second') {
            $response = $this->makeSecondTransfer();
            if (!$response['status']) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            return $response;
        }

        $response = $this->makeFirstTransfer();
        if (!$response['status']) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $response;
    }

    /**
     * En este método se creará una nueva hoja para la hoja actual y se le asignará el estado (Transferido).
     * 
     * Para el nuevo responsable, 
     * si tiviera una hoja se creará una nueva hoja duplicando los artículos y agregando los articulos transferidos,
     * si no, se creagara una nueva hoja con los artículos transferidos.
     * 
     * @return array
     */
    protected function makeFirstTransfer(): array
    {
        // Antes de todo se carga la actual hoja
        $currentSheet = ResponsabilitySheet::find($this->current_sheet_id);

        /** ========== Seccíón del nuevo responsable ========== */

        // Se carga el nuevo responsable
        $newResponsible = User::find($this->new_responsible_id);
        if (!$newResponsible) {
            return $this->responseArray('Responsible not found');
        }

        // Se creara una nueva hoja
        $newOtherSheet = $this->createNewSheet($this->new_responsible_id);
        $newOrder = 1;

        // Se carga la hoja existente del nuevo responsable
        $otherSheetBefore = ResponsabilitySheet::where('id_responsible', $newResponsible->id)
            ->where('status', ResponsabilitySheetStatusEnum::Closed->value)
            ->orderByDesc('id')
            ->first();

        if ($otherSheetBefore && isset($otherSheetBefore->id)) {
            $otherSheetBefore->update(['status' => ResponsabilitySheetStatusEnum::Received->value]);

            foreach ($otherSheetBefore->lines as $line) {
                $this->transferLineToNewResponsible($line, $newOtherSheet, $newOrder);

                $newOrder++;
            }
        }

        // Ahora se cargaran las líneas que se transfieren
        foreach ($this->lines_to_transfer as $line_id) {
            $line = LineResponsabilitySheet::find($line_id);

            $oldResonsibleName = $currentSheet->responsible->name;
            $this->transferLineToNewResponsible($line, $newOtherSheet, $newOrder, $oldResonsibleName);

            $newOrder++;
        }

        // Se actualizan los valores de la nueva hoja
        $newOtherSheet->recalculate();

        /** ========== Seccíón del antiguo responsable ========== */

        // Se actualizan los valores de la hoja actual
        $currentSheet->update([
            'status' => ResponsabilitySheetStatusEnum::Transferred->value,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        $currentNewSheet = $this->createNewSheet($currentSheet->id_responsible, ++$newOtherSheet->number);
        $newOrder = 1;

        $transferLinesIds = array_keys($this->lines_to_transfer);

        // Ahora se recorren las líneas de la hoja actual
        foreach ($currentSheet->lines as $line) {
            $newResponsibleName = null;

            // Si la línea se transfirió, se resta el valor de la línea en la hoja actual
            if (in_array($line->id, $transferLinesIds)) {
                $newResponsibleName = $newOtherSheet->responsible->name;
            }

            $this->transferLineToCurrentResponsible($line, $currentNewSheet, $newOrder, $newResponsibleName);

            $newOrder++;
        }

        // Se actualizan los valores de la hoja nueva actual
        $currentNewSheet->recalculate();

        return $this->responseArray('Transfer done', true);
    }

    /**
     * En esté método solo se actualizarán ambas hojas con el estado (Modificado).
     * 
     * Si el nuevo responsable no posee una hoja, se creará una nueva hoja con los artículos transferidos.
     * @return array
     */
    protected function makeSecondTransfer(): array
    {
        // Antes de todo se carga la actual hoja
        $currentSheet = ResponsabilitySheet::find($this->current_sheet_id);

        /** ========== Seccíón del nuevo responsable ========== */

        // Se carga el nuevo responsable
        $newResponsible = User::find($this->new_responsible_id);
        if (!$newResponsible) {
            return $this->responseArray('Responsible not found');
        }

        // Se creara una nueva hoja
        $newOrder = 1;

        // Se carga la hoja existente del nuevo responsable
        $otherSheet = ResponsabilitySheet::where('id_responsible', $newResponsible->id)
            ->where('status', ResponsabilitySheetStatusEnum::Closed->value)
            ->orderByDesc('id')
            ->first();

        if ($otherSheet) {
            $otherSheet->update([
                'status' => ResponsabilitySheetStatusEnum::Modified->value
            ]);
        }

        if (empty($otherSheet) || empty($otherSheet->id)) {
            $otherSheet = $this->createNewSheet($newResponsible->id);
        }

        // Ahora se cargaran las líneas que se transfieren
        foreach ($this->lines_to_transfer as $line_id) {
            $line = LineResponsabilitySheet::find($line_id);

            $oldResonsibleName = $currentSheet->responsible->name;
            $this->transferLineToNewResponsible($line, $otherSheet, $newOrder, $oldResonsibleName);

            $newOrder++;
        }

        $otherSheet->recalculate();

        /** ========== Seccíón del antiguo responsable ========== */
        $newOrder = 1;

        // Se actualizan los valores de la hoja actual
        $currentSheet->update([
            'status' => ResponsabilitySheetStatusEnum::Modified->value,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        // Ahora se recorren las líneas de la hoja actual
        $oldResponsibleName = $otherSheet->responsible->name;
        foreach ($this->lines_to_transfer as $line_id) {
            $line = LineResponsabilitySheet::find($line_id);

            $this->updateLine($line, $newOrder, $oldResponsibleName);

            $newOrder++;
        }

        // Se actualizan los valores de la hoja actual
        $currentSheet->recalculate();

        return $this->responseArray('Transfer done', true);
    }

    /**
     * Crea una nueva hoja de responsabilidad para el nuevo responsable.
     * 
     * La hoja se crea con el estado (Abierta) y con el número
     * siguiente al de la hoja del responsable actual.
     * 
     * @return ResponsabilitySheet La hoja recién creada.
     */
    protected function createNewSheet(int $responsible_id, ?string $number = null)
    {
        $number = $number ?? ResponsabilitySheet::getNextNumber();

        return ResponsabilitySheet::create([
            'number' => $number,
            'id_responsible' => $responsible_id,
            'status' => ResponsabilitySheetStatusEnum::Open->value,
            'created_by' => Auth::user()->id
        ]);
    }

    protected function updateLine(LineResponsabilitySheet &$line, int $order, ?string $new_responsible = null)
    {
        $cashIn = $line->cash_in;
        $cashOut = $line->cash_out;
        $balance = $line->balance;

        $observations = $line->observations;
        $date = $line->date;

        if (!empty($new_responsible)) {
            $date = Carbon::now();
            $cashIn = 0.0;
            $cashOut = $cashIn;
            $balance -= $cashOut;
            $observations = __('Transfer to :responsible', ['responsible' => $new_responsible]) . ' - ' . $observations;
        }

        $line->update([
            'order' => $order,
            'balance' => $balance,
            'cash_in' => $cashIn,
            'cash_out' => $cashOut,
            'updated_by' => Auth::user()->id,
            'date' => $date,
            'observations' => $observations,
        ]);
    }

    /**
     * Transfiere una línea de una hoja de responsabilidad a la hoja del nuevo responsable.
     * 
     * Si se proporciona un nuevo responsable, se actualiza la fecha y se
     * agrega una observación con el texto "Transfer from :responsible".
     * 
     * @param LineResponsabilitySheet $line La línea a transferir.
     * @param ResponsabilitySheet $new_sheet La hoja actual.
     * @param int $order El orden de la línea en la hoja actual.
     * @param string $old_responsible El antiguo responsable.
     * @return LineResponsabilitySheet La línea transferida.
     */
    protected function transferLineToNewResponsible(LineResponsabilitySheet &$line, ResponsabilitySheet &$new_sheet, int $order, ?string $old_responsible = null)
    {
        $observations = $line->observations;
        $date = $line->date;

        if (!empty($old_responsible)) {
            $date = Carbon::now();
            $observations = __('Transfer from :responsible', ['responsible' => $old_responsible]) . ' - ' . $observations;
        }

        return LineResponsabilitySheet::create([
            'id_sheet' => $new_sheet->id,
            'date' => $date,
            'id_item' => $line->id_item,
            'order' => $order,
            'balance' => $line->balance,
            'cash_in' => $line->cash_in,
            'cash_out' => $line->cash_out,
            'observations' => $observations,
            'created_by' => Auth::user()->id
        ]);
    }

    /**
     * Transfiere una línea de una hoja de responsabilidad a la hoja actual.
     * 
     * Si se proporciona un nuevo responsable, se actualiza la fecha y se
     * agrega una observación con el texto "Transfer to :responsible".
     * 
     * @param LineResponsabilitySheet $line La línea a transferir.
     * @param ResponsabilitySheet $new_sheet La hoja actual.
     * @param int $order El orden de la línea en la hoja actual.
     * @param string $new_responsible El nuevo responsable.
     * @return LineResponsabilitySheet La línea transferida.
     */
    protected function transferLineToCurrentResponsible(LineResponsabilitySheet &$line, ResponsabilitySheet &$new_sheet, int $order, ?string $new_responsible = null)
    {
        $observations = $line->observations;
        $date = $line->date;

        $cashIn = $line->cash_in;
        $cashOut = $line->cash_out;
        $balance = $line->balance;

        if (!empty($new_responsible)) {
            $cashOut = $cashIn;
            $cashIn = 0;

            $balance -= $cashOut;
            $date = Carbon::now();
            $observations = __('Transfer to :responsible', ['responsible' => $new_responsible]) . ' - ' . $observations;
        }

        return LineResponsabilitySheet::create([
            'id_sheet' => $new_sheet->id,
            'date' => $date,
            'id_item' => $line->id_item,
            'order' => $order,
            'balance' => $balance,
            'cash_in' => $cashIn,
            'cash_out' => $cashOut,
            'observations' => $observations,
            'created_by' => Auth::user()->id
        ]);
    }
}
