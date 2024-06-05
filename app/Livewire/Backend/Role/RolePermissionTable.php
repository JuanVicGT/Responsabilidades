<?php

namespace App\Livewire\Backend\Role;

use App\Models\Permission;
use App\Models\Role;
use App\Utils\Alerts;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class RolePermissionTable extends Component
{
    use Toast;
    use Alerts;
    use WithPagination;

    public Role $role;

    // Filters
    public int $pagination = 10;
    public string $search = '';
    public array $sortBy = ['column' => 'name', 'direction' => 'desc'];

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    protected function getTableHeaders(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-red-500/20 w-1'],
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'status', 'label' => __('Have Permission?')],
        ];
    }

    protected function getTableRows()
    {
        return Permission::when(
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
            'livewire.backend.role.role-permission-table',
            [
                'permissions' => $this->getTableRows(),
                'headers' => $this->getTableHeaders(),
            ]
        );
    }

    public function revokePermission($id)
    {
        $permission = Permission::find($id);
        $this->role->revokePermissionTo($permission);
        $this->info(
            title: __('Permission Revoked'),
            icon: 'o-check-circle',
            position: 'toast-top toast-center'
        );
    }

    public function givePermission($id)
    {
        $permission = Permission::find($id);
        $this->role->givePermissionTo($permission);
        $this->success(
            title: __('Permission Granted'),
            icon: 'o-check-circle',
            position: 'toast-top toast-center'
        );
    }
}
