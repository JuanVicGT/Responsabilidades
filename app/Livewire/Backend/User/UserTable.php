<?php

namespace App\Livewire\Backend\User;

use App\Http\Services\AppSettingService;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Utils\Alerts;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Gate;

class UserTable extends Component
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
            ['key' => 'role', 'label' => __('Role')],
            ['key' => 'is_active', 'label' => __('Is Active')],
            ['key' => 'need_password_reset', 'label' => __('Need Password Reset?')],
        ];
    }

    protected function getTableRows()
    {
        if ($this->search !== '' && $this->search !== $this->previousSearch) {
            $this->resetPage(); // Resetear la paginación
            $this->previousSearch = $this->search;
        }

        return User::when(
            !Auth::user()->is_admin,

            fn($query) =>
            $query->whereNull('is_admin')
        )
            ->when(
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
            'livewire.backend.user.user-table',
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
        $collaborater = User::find($this->deleteId);
        Gate::authorize('delete', $collaborater);
        $hasDeleted = $collaborater->delete();

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
