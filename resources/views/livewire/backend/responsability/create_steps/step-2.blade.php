@php
    $canCreate = auth()->user()->is_admin || auth()->user()->can('create_item');
@endphp

<x-mary-step step="2" text="{{ __('Assign Items') }}">
    {{-- Section 1 : Select Items --}}
    <section class="grid grid-cols-1">
        <div>
            <p class="text-xl text-center">{{ __('Assign Responsibilities') }}</p>
        </div>

        {{-- Section 1.2 : Load item and form to add line --}}
        <div class="grid grid-cols-4 gap-4">

            {{-- Choice Input and load item button --}}
            <div class="col-span-4">
                <x-mary-choices label="{{ __('Item') }}" debounce="500ms" wire:model="form_step2_id_item" single
                    x-ref="item_search" no-result-text="{{ __('No results found.') }}" :options="$step2_option_items" searchable
                    search-function="searchItems">

                    {{-- Item slot --}}
                    @scope('item', $item)
                        <x-mary-list-item :item="$item" value="description" sub-value="code" />
                    @endscope

                    {{-- Selection slot --}}
                    @scope('selection', $item)
                        {{ $item->description }}
                    @endscope

                    @if ($canCreate)
                        <x-slot:append>
                            <x-mary-button label="{{ __('Load Item') }}" icon="o-plus"
                                class="rounded-s-none btn-accent dark:btn-info" wire:click='loadItem' spinner />
                        </x-slot:append>
                    @endif
                </x-mary-choices>
            </div>

            {{-- Item Code --}}
            <div>
                @if ($canCreate)
                    <x-mary-input label="{{ __('Code ID') }}" type="text" required wire:model='form_step2_code' />
                @endif
            </div>

            {{-- Item Quantity --}}
            <div>
                @if ($canCreate)
                    <x-mary-input type="number" label="{{ __('Quantity') }}" step="1" min="1" required
                        wire:model='form_step2_line_quantity' />
                @endif
            </div>

            {{-- Item Amount --}}
            <div>
                @if ($canCreate)
                    <x-mary-input type="number" label="{{ __('Amount') }}" prefix="Q" step="any" required
                        wire:model='form_step2_line_amount' />
                @endif
            </div>

            {{-- Date --}}
            @if ($canCreate)
                <div>
                    <x-mary-datetime label="{{ __('Date') }}" wire:model="form_step2_date" required
                        icon="o-calendar" />
                </div>
            @else
                <div class="col-span-4">
                    <x-mary-datetime label="{{ __('Date') }}" wire:model="form_step2_date" required
                        icon="o-calendar" />
                </div>
            @endif

            {{-- Item Description --}}
            <div class="col-span-4">
                @if ($canCreate)
                    <x-mary-textarea label="{{ __('Description') }}" required rows="2"
                        wire:model='form_step2_line_description' />
                @endif
            </div>

            {{-- Line Observations --}}
            <div class="col-span-4">
                <x-mary-textarea label="{{ __('Observations') }}" required rows="5"
                    wire:model='form_step2_line_observation' />
            </div>

            <div class="flex col-span-4 justify-end">
                <x-mary-button label="{{ __('Add Line') }}" icon="o-plus" class="rounded-s-none btn-success"
                    wire:click='addLine' spinner />
            </div>
        </div>
    </section>

    {{-- Section 2 : Items assigned --}}
    <section class="grid grid-cols-1 mt-4">
        <hr class="w-full h-1 bg-gray-300">
        <div class="mt-2">
            <p class="text-xl text-center">{{ __('Responsibilities Assigned') }}</p>
        </div>
        <x-mary-table :headers="$step2_table_item_headers" :rows="$step2_lines">
            {{-- Overrides headers --}}
            @scope('header_order', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_date', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_code', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_description', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_quantity', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_cash_in', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_cash_out', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_balance', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope
            @scope('header_observations', $header)
                <h3 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h3>
            @endscope

            {{-- Overrides rows --}}
            @scope('cell_amount', $row)
                Q {{ $row['amount'] }}
            @endscope

            @scope('cell_date', $row)
                {{ \Carbon\Carbon::parse($row['date'])->format('d/m/Y') }}
            @endscope

            @scope('actions', $row)
                <x-mary-button icon="o-minus-circle" class="btn-sm btn-error text-white dark:text-black" spinner
                    wire:click="removeLine({{ $row['item_id'] }})" />
            @endscope
        </x-mary-table>
    </section>
</x-mary-step>
