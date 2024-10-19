<?php

namespace App\Livewire\Backend\Prequest;

use App\Http\Services\AppSettingService;
use App\Models\PasswordResetRequest;
use Livewire\Component;

use App\Utils\Alerts;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class PrequestTable extends Component
{
    use Toast;
    use Alerts;
    use WithPagination;

    // Modals
    public bool $deleteModal = false;

    // Filters
    public string $search = '';
    public string $previousSearch = ''; // Use to reset pagination in case of a new search
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

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
            ['key' => 'user.username', 'label' => __('Username')],
            ['key' => 'status', 'label' => __('Status')],
            ['key' => 'created_at', 'label' => __('Requested at')],
            ['key' => 'updated_at', 'label' => __('Processed at')],
            ['key' => 'description', 'label' => __('Description')]
        ];
    }

    protected function getTableRows()
    {
        if ($this->search !== '' && $this->search !== $this->previousSearch) {
            $this->resetPage(); // Resetear la paginación
            $this->previousSearch = $this->search;
        }

        return PasswordResetRequest::when(
            $this->search,

            fn($query) =>
            $query->where('username', 'like', "%{$this->search}%")
        )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->pagination)
        ;
    }

    public function render()
    {
        return view(
            'livewire.backend.prequest.prequest-table',
            [
                'rows' => $this->getTableRows(),
                'headers' => $this->getTableHeaders(),
            ]
        );
    }
}
