<?php

namespace App\Livewire\Backend\Event;

use App\Models\Event;
use App\Utils\Alerts;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class EventTable extends Component
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
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'status', 'label' => __('Status')],
            ['key' => 'start_date', 'label' => __('Start Date')],
            ['key' => 'end_date', 'label' => __('End Date')],
        ];
    }

    protected function getTableRows()
    {
        return Event::when(
            $this->search,

            fn ($query) =>
            $query->where('name', 'like', "%{$this->search}%")
        )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->pagination);
    }

    public function render()
    {
        return view(
            'livewire.backend.event.event-table',
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
        $event = Event::find($this->deleteId);
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
