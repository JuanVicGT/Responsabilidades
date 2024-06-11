<?php

namespace App\Livewire\Backend\Item;

use App\Models\Item;
use App\Utils\Alerts;
use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class ItemTable extends Component
{
    use Toast;
    use Alerts;
    use WithPagination;

    // Properties
    public $deleteId;

    // Modals
    public bool $deleteModal = false;

    // Filters
    public int $pagination = 10;
    public string $search = '';
    public array $sortBy = ['column' => 'name', 'direction' => 'desc'];

    protected function getTableHeaders(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'code', 'label' => __('Code')],
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'serial', 'label' => __('Serial')],
            ['key' => 'unit_value', 'label' => __('Unit Value')],
            ['key' => 'quantity', 'label' => __('Quantity')],
            ['key' => 'amount', 'label' => __('Total Amount')],
        ];
    }

    protected function getTableRows()
    {
        return Item::when(
            $this->search,

            fn ($query) =>
            $query->where('code', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', "%{$this->search}%")
        )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->pagination);
    }

    public function render()
    {
        return view(
            'livewire.backend.item.item-table',
            [
                'rows' => $this->getTableRows(),
                'headers' => $this->getTableHeaders(),
            ]
        );
    }

    public function showDeleteModal($id)
    {
        $this->deleteId = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $event = Item::find($this->deleteId);
        Gate::authorize('delete', $event);
        $hasDeleted = $event->delete();

        $this->deleteId = null;
        $this->deleteModal = false;

        if ($hasDeleted)
            $this->success(
                title: __('Deleted Successfully'),
                icon: 'o-check-circle',
                position: 'toast-top toast-center'
            );
        else
            $this->error(
                title: __('Could not be deleted'),
                icon: 'o-x-circle',
                position: 'toast-top toast-center'
            );
    }
}
