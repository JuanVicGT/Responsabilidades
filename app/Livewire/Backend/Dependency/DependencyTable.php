<?php

namespace App\Livewire\Backend\Dependency;

use App\Http\Services\AppSettingService;
use App\Models\Dependency;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use App\Utils\Alerts;
use Illuminate\Support\Facades\Gate;

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
    public string $search = '';
    public string $previousSearch = ''; // Use to reset pagination in case of a new search
    public array $sortBy = ['column' => 'name', 'direction' => 'desc'];

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
            ['key' => 'id', 'label' => '#', 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'name', 'label' => __('Name')],
        ];
    }

    protected function getTableRows()
    {
        if ($this->search !== '' && $this->search !== $this->previousSearch) {
            $this->resetPage(); // Resetear la paginación
            $this->previousSearch = $this->search;
        }

        return Dependency::when(
            $this->search,

            fn($query) =>
            $query->where('name', 'like', "%{$this->search}%")
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
        $dependency = Dependency::find($this->deleteId);
        Gate::authorize('delete', $dependency);
        $hasDeleted = $dependency->delete();

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
