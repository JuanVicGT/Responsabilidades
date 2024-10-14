<?php

namespace App\Livewire\Backend\Prequest;

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
    public int $pagination = 10;
    public string $search = '';
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

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
        return PasswordResetRequest::when(
            $this->search,

            fn ($query) =>
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
