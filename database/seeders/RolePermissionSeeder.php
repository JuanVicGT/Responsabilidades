<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRoles();
    }

    protected function getPermissions(): array
    {
        return ['index', 'show', 'create', 'edit', 'delete'];
    }

    protected function getModels(): array
    {
        return [
            'dependency',
            'responsability',
            'user',
            'attendence',
            'event',
            'todo',
            'item',
            'role',
            'permission',
            'reset_password'
        ];
    }

    protected function createPermission(string $model)
    {
        foreach ($this->getPermissions() as $permission) {
            Permission::create(['name' => "{$permission}_{$model}"]);
        }
    }

    protected function createRoles(): void
    {
        Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Encargado']);
        Role::create(['name' => 'Empleado']);

        foreach ($this->getModels() as $model) {
            $this->createPermission($model);
        }
    }
}
