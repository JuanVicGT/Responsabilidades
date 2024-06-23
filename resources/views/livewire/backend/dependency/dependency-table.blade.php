<section>
    <x-mary-card shadow class="py-0">
        <div class="flex py-4">
            <div class="flex justify-end">
                <x-mary-input icon="o-magnifying-glass" wire:model.live='search' placeholder="{{ __('search') }}..."
                    class="border-gray-500" />
            </div>
        </div>

        {{-- You can use any `$wire.METHOD` on `@row-click` --}}
        <x-mary-table :headers="$headers" :rows="$rows" with-pagination :sort-by="$sortBy" class="pb-4" striped
            link="Dependency/Edit/{id}">

            {{-- Overrides headers --}}
            @scope('header_id', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_code', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_name', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope

            @scope('actions', $row)
                @if (auth()->user()->is_admin || auth()->user()->can('delete_dependency'))
                    <x-mary-button icon="o-trash" spinner class="btn-sm btn-error text-white dark:text-black"
                        wire:click="showDeleteModal({{ $row->id }})" />
                @endif
            @endscope

        </x-mary-table>

        <x-mary-modal wire:model="deleteModal" class="backdrop-blur">
            <x-mary-header title="{{ __('Are you sure?') }}" subtitle="{{ __('Press confirm button to delete') }}" />
            <x-mary-form wire:submit="delete">
                <div class="w-full flex justify-end space-x-4">
                    <x-mary-button label="{{ __('Cancel') }}" class="btn-neutral" @click="$wire.deleteModal = false" />
                    <x-mary-button label="{{ __('Confirm') }}" class="btn-error text-white dark:text-black" type="submit" spinner="delete" />
                </div>
            </x-mary-form>
        </x-mary-modal>
    </x-mary-card>
</section>
