<?php

namespace App\Livewire\Backend\Todo;

use App\Http\Services\AppSettingService;
use App\Models\Todo;
use App\Policies\GeneralPolicy;
use App\Utils\Alerts;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class TodoTable extends Component
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
            ['key' => 'status', 'label' => __('Status')],
            ['key' => 'date', 'label' => __('Date')],
            ['key' => 'hour', 'label' => __('Hour')],
            ['key' => 'description', 'label' => __('Description'), 'class' => 'hidden'],
        ];
    }

    protected function getTableRows()
    {
        if ($this->search !== '' && $this->search !== $this->previousSearch) {
            $this->resetPage(); // Resetear la paginación
            $this->previousSearch = $this->search;
        }

        return Todo::where('id_user', Auth::user()->id)
            ->when(
                $this->search,

                fn($query) =>
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
            )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->pagination);
    }

    public function render()
    {
        return view(
            'livewire.backend.todo.todo-table',
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
        $todo = Todo::find($this->deleteId);
        $module_name = 'todo';
        $module_action = 'delete';
        Gate::allowIf(GeneralPolicy::$module_action(Auth::user(), $module_name));
        $hasDeleted = $todo->delete();

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
