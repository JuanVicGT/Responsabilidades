<?php

namespace App\Livewire\Backend\Responsability;

use App\Models\ResponsabilitySheet;
use Livewire\Component;

use App\Http\Services\AppSettingService;
use App\Policies\GeneralPolicy;
use App\Utils\Alerts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ResponsabilitySheetTable extends Component
{
    use Toast;
    use Alerts;
    use WithPagination;

    // Properties
    public $dismissId;

    // Modals
    public bool $deleteModal = false;

    // Filters
    public string $search = '';
    public string $previousSearch = ''; // Use to reset pagination in case of a new search
    public array $sortBy = ['column' => 'number', 'direction' => 'desc'];

    public int $pagination = 10;
    public array $pagination_options = [['id' => 10, 'name' => '10'], ['id' => 25, 'name' => '25'], ['id' => 50, 'name' => '50'], ['id' => 75, 'name' => '75']];

    public function mount()
    {
        $config = app(AppSettingService::class);

        $pagination = $config->get('pagination');
        if (is_numeric($pagination)) {
            $this->pagination = $pagination;
        }
    }

    protected function getTableHeaders(): array
    {
        return [
            ['key' => 'number', 'label' => '#', 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'id_responsible', 'label' => __('Responsible')],
            ['key' => 'cash_in', 'label' => __('Cash in')],
            ['key' => 'cash_out', 'label' => __('Cash out')],
            ['key' => 'balance', 'label' => __('Balance')],
        ];
    }

    protected function getTableRows()
    {
        if ($this->search !== '' && $this->search !== $this->previousSearch) {
            $this->resetPage(); // Resetear la paginación
            $this->previousSearch = $this->search;
        }

        return ResponsabilitySheet::when(
            $this->search,

            fn($query) =>
            $query->where('number', 'like', "%{$this->search}%")
        )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->pagination);
    }

    public function render()
    {
        return view(
            'livewire.backend.responsability.responsability-sheet-table',
            [
                'rows' => $this->getTableRows(),
                'headers' => $this->getTableHeaders(),
            ]
        );
    }

    public function showDeleteModal($id)
    {
        $this->dismissId = $id;
        $this->deleteModal = true;
    }

    public function dismiss()
    {
        $sheet = ResponsabilitySheet::find($this->dismissId);
        $module_name = 'responsability';
        $module_action = 'delete';
        Gate::allowIf(GeneralPolicy::$module_action(Auth::user(), $module_name));

        $sheet->status = '0';
        $hasDismiss = $sheet->save();

        $this->dismissId = null;
        $this->deleteModal = false;

        if ($hasDismiss)
            $this->success(
                title: __('Dismissed Successfully'),
                icon: 'o-check-circle',
                position: 'toast-top toast-center'
            );
        else
            $this->error(
                title: __('Could not be dismissed'),
                icon: 'o-x-circle',
                position: 'toast-top toast-center'
            );
    }
}
