<section>
    <x-mary-card shadow class="py-0">
        <div class="flex py-4 justify-between">
            <div class="flex justify-start space-x-4">
                <x-mary-input icon="o-magnifying-glass" wire:model.live='search' placeholder="{{ __('search') }}..."
                    class="border-gray-500" clearable />
                <x-mary-select :options="$pagination_options" wire:model.live="pagination" class="h-2" />
            </div>
            <div class="flex justify-start space-x-4">
                <div>
                    {{ $rows->onEachSide(0)->links('components.layouts.custom-pagination') }}
                </div>
            </div>
        </div>

        {{-- You can use any `$wire.METHOD` on `@row-click` --}}
        <x-mary-table :headers="$headers" :rows="$rows" :sort-by="$sortBy" class="pb-4" with-pagination striped
            link="Responsability/Edit/{id}">

            {{-- Overrides headers --}}
            @scope('header_number', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_id_responsible', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_cash_in', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_cash_out', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_balance', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope

            @scope('cell_id_responsible', $row)
                {{ $row->responsible->name }}
            @endscope

            @scope('actions', $row)
                @if (auth()->user()->is_admin || auth()->user()->can('delete_responsability'))
                    {{-- TODO: Por el momento no se puede eliminar --}}
                    @if (false)
                        <x-mary-button icon="o-trash" spinner class="btn-sm btn-error text-white dark:text-black"
                            wire:click="showdismissModal({{ $row->id }})" />
                    @endif
                @endif
            @endscope

        </x-mary-table>

        <x-mary-modal wire:model="dismissModal" class="backdrop-blur">
            <x-mary-header title="{{ __('Are you sure?') }}" subtitle="{{ __('Press confirm button to dismiss') }}" />
            <x-mary-form wire:submit="dismiss">
                <div class="w-full flex justify-end space-x-4">
                    <x-mary-button label="{{ __('Cancel') }}" class="btn-neutral"
                        @click="$wire.dismissModal = false" />
                    <x-mary-button label="{{ __('Confirm') }}" class="btn-error" type="submit" spinner="dismiss" />
                </div>
            </x-mary-form>
        </x-mary-modal>

    </x-mary-card>
</section>
