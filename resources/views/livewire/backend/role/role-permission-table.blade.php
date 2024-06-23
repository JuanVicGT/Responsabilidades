<section>
    <x-mary-card shadow class="py-0">
        <div class="flex py-4">
            <div class="flex justify-end">
                <x-mary-input icon="o-magnifying-glass" wire:model.live='search' placeholder="{{ __('search') }}..."
                    class="border-gray-500" />
            </div>
        </div>

        {{-- You can use any `$wire.METHOD` on `@row-click` --}}
        <x-mary-table :headers="$headers" :rows="$permissions" with-pagination :sort-by="$sortBy" class="pb-4" striped>

            {{-- Overrides headers --}}
            @scope('header_id', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_name', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_status', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope

            @scope('cell_status', $permission)
                @if ($this->role->hasPermissionTo($permission->name))
                    <x-mary-badge value="{{ __('YES') }}" class="badge-success" />
                @else
                    <x-mary-badge value="{{ __('NO') }}" class="badge-warning" />
                @endif
            @endscope

            @scope('actions', $permission)
                @if (auth()->user()->is_admin || auth()->user()->can('edit_role'))
                    @if ($this->role->hasPermissionTo($permission->name))
                        <x-mary-button icon="o-lock-closed" spinner class="btn-sm btn-error text-white dark:text-black"
                            wire:click="revokePermission({{ $permission->id }})" />
                    @else
                        <x-mary-button icon="o-lock-open" spinner class="btn-sm btn-success"
                            wire:click="givePermission({{ $permission->id }})" />
                    @endif
                @endif
            @endscope

        </x-mary-table>
    </x-mary-card>
</section>
