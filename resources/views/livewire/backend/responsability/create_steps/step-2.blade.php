<x-mary-step step="2" text="{{ __('Assign Items') }}">
    {{-- Section 1 : Select Items --}}
    <section class="grid grid-cols-1">
        <div>
            <p class="text-xl text-center">{{ __('Assign Responsibilities') }}</p>
        </div>
        <div>
            <x-mary-choices label="{{ __('Item') }}" debounce="500ms" wire:model="form_id_item" single
                no-result-text="{{ __('No results found.') }}" :options="$option_items" searchable search-function="searchItems">

                {{-- Item slot --}}
                @scope('item', $item)
                    <x-mary-list-item :item="$item" value="description" sub-value="code" />
                @endscope

                {{-- Selection slot --}}
                @scope('selection', $item)
                    {{ $item->description }}
                @endscope

                <x-slot:append>
                    <x-mary-button label="{{ __('Add Line') }}" icon="o-plus"
                        class="rounded-s-none btn-accent dark:btn-info" wire:click='addLine' spinner />
                </x-slot:append>
            </x-mary-choices>
        </div>

        @if (auth()->user()->is_admin || auth()->user()->can('create_item'))
            <div class="mt-4" x-data="{ open: false }">
                <div class="flex justify-center">
                    <x-mary-button label="{{ __('Create New Item') }}" class="rounded-s-none btn-accent dark:btn-info"
                        x-on:click="open = !open" />
                </div>

                <x-mary-card x-show="open">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-mary-input label="{{ __('Quantity') }}" type="number" step="1" name='quantity'
                                required value="{{ old('quantity', 1) }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                        </div>
                        <div>
                            <x-mary-input label="{{ __('Total') }}" name='amount' value="{{ old('amount') }}"
                                prefix="Q" type="number" step="any" required />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>
                        <div class="col-span-2">
                            <x-mary-textarea label="{{ __('Description') }}" type="text" name='description' required
                                rows="5">{{ old('description') }}</x-mary-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-mary-button label="{{ __('Create Item and Add Line') }}" icon="o-plus"
                            class="rounded-s-none btn-success" spinner="createItemAndAddLine" />
                    </div>
                </x-mary-card>
            </div>
        @endif
    </section>

    {{-- Section 2 : Items assigned --}}
    <section class="grid grid-cols-1 mt-4">
        <hr class="w-full h-1 bg-gray-300">
        <div class="mt-2">
            <p class="text-xl text-center">{{ __('Responsibilities Assigned') }}</p>
        </div>
        <x-mary-table :headers="$table_item_headers" :rows="$lines">
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

            @scope('actions', $row)
                @if (auth()->user()->is_admin || auth()->user()->can('delete_permission'))
                    <x-mary-button icon="o-trash" class="btn-sm btn-error text-white dark:text-black" spinner
                        wire:click="removeLine({{ $row->id }})" />
                @endif
            @endscope
        </x-mary-table>
    </section>
</x-mary-step>
