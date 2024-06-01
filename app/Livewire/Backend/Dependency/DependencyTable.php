<?php

namespace App\Livewire\Backend\Dependency;

use App\Models\Dependency;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use App\Utils\Alerts;

class DependencyTable extends Component
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
    public array $sortBy = ['column' => 'code', 'direction' => 'desc'];

    protected function getTableHeaders(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'code', 'label' => __('Code')],
            ['key' => 'name', 'label' => __('Name')],
        ];
    }

    protected function getTableRows()
    {
        return Dependency::when(
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
            'livewire.backend.dependency.dependency-table',
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
        $modal = Dependency::find($this->deleteId);
        $hasDeleted = $modal->delete();

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
