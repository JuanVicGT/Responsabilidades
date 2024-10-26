@php
    $canCreate = auth()->user()->is_admin || auth()->user()->can('create_item');
@endphp

<div>
    {{-- Sección 1 : Información general --}}
    <section>
        <x-mary-card shadow>
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-2">
                    <x-mary-input label="{{ __('Number') }}" wire:model="number" required readonly />
                </div>
                @if ($isAvailable)
                    <div class="col-span-2">
                        <x-mary-choices label="{{ __('Responsable') }}" debounce="500ms" wire:model="responsible_id" single
                            icon="o-user" no-result-text="{{ __('No results found.') }}" required
                            class="max-h-12 external-choice" :options="$option_users" searchable search-function="searchUsers">
                            {{-- Item slot --}}
                            @scope('item', $user)
                                <x-mary-list-item :item="$user" sub-value="work_position">
                                    <x-slot:avatar>
                                        @if ($user->avatar)
                                            <x-mary-avatar image="{{ asset('storage/' . $user->avatar) }}"
                                                class="bg-orange-100 w-8 h8 rounded-full" />
                                        @else
                                            <x-mary-icon name="o-user" class="bg-orange-100 p-2 w-8 h8 rounded-full" />
                                        @endif
                                    </x-slot:avatar>
                                </x-mary-list-item>
                            @endscope
                        </x-mary-choices>
                    </div>
                @else
                    <div class="col-span-2">
                        <x-mary-input label="{{ __('Responsible') }}" wire:model="responsible_name" required readonly />
                    </div>
                @endif
            </div>

            {{-- Botones para cuando esta disponible la hoja --}}
            <div x-show="$wire.isAvailable" class="flex col-span-4 justify-between mt-2">
                <x-mary-button label="{{ __('Block Sheet') }}" icon="o-lock-closed" class="rounded-s-none btn-warning"
                    spinner wire:click="blockSheet" />
                <x-btn-save spinner wire:click="save" />
            </div>

            {{-- Botones para cuando no esta disponible la hoja --}}
            <div x-show="!$wire.isAvailable" class="flex col-span-4 justify-between mt-2">
                <x-mary-button label="{{ __('Print') }}" icon="o-printer" class="rounded-s-none btn-accent" spinner
                    wire:click="printSheet" />
                <x-mary-button label="{{ __('Make Transfer') }}" icon="o-arrows-right-left"
                    class="rounded-s-none btn-warning" spinner wire:click="showTransferModal" />
            </div>
        </x-mary-card>
    </section>

    {{-- Sección 2 : Sección de items --}}
    <section>
        <x-mary-card shadow class="mt-4">
            {{-- Choice de items --}}
            <div x-show="$wire.isAvailable" class="col-span-4">
                <x-mary-choices label="{{ __('Item') }}" debounce="500ms" wire:model="id_item" single
                    no-result-text="{{ __('No results found.') }}" :options="$option_items" searchable
                    search-function="searchItems" @change-selection="$wire.loadItem" readonly="{{ !$isAvailable }}">

                    {{-- Item slot --}}
                    @scope('item', $item)
                        <x-mary-list-item :item="$item" value="description" sub-value="code" />
                    @endscope

                    {{-- Selection slot --}}
                    @scope('selection', $item)
                        {{ $item->description }}
                    @endscope

                    <x-slot:append>
                        <x-mary-button label="{{ __('Load Item') }}" icon="o-plus"
                            class="rounded-s-none btn-accent dark:btn-info" wire:click='loadItem' spinner />
                    </x-slot:append>
                </x-mary-choices>

                @if ($canCreate)
                    <div x-show="$wire.show_create_btn" class="flex col-span-4 justify-center mt-2">
                        <x-mary-button label="{{ __('Create New Item') }}" icon="o-plus"
                            class="rounded-s-none btn-info" x-on:click="$wire.show_form = !$wire.show_form" />
                    </div>
                @endif

                {{-- Sección 2.1 : Infrmación del item seleccionado --}}
                <div x-show="$wire.show_form" class="col-span-4 grid grid-cols-4 gap-4 pt-4">
                    {{-- Item Code --}}
                    <div>
                        @if ($canCreate)
                            <x-mary-input label="{{ __('Code ID') }}" type="text" required wire:model='line_code' />
                        @endif
                    </div>

                    {{-- Item Quantity --}}
                    <div>
                        @if ($canCreate)
                            <x-mary-input type="number" label="{{ __('Quantity') }}" step="1" min="1"
                                required wire:model='line_quantity' />
                        @endif
                    </div>

                    {{-- Item Amount --}}
                    <div>
                        @if ($canCreate)
                            <x-mary-input type="number" label="{{ __('Amount') }}" prefix="Q" step="any"
                                required wire:model='line_amount' />
                        @endif
                    </div>

                    {{-- Date --}}
                    @if ($canCreate)
                        <div>
                            <x-mary-datetime label="{{ __('Date') }}" wire:model="line_date" required
                                icon="o-calendar" />
                        </div>
                    @else
                        <div class="col-span-4">
                            <x-mary-datetime label="{{ __('Date') }}" wire:model="line_date" required
                                icon="o-calendar" />
                        </div>
                    @endif

                    {{-- Item Description --}}
                    <div class="col-span-4">
                        @if ($canCreate)
                            <x-mary-textarea label="{{ __('Description') }}" required rows="2"
                                wire:model='line_description' />
                        @endif
                    </div>

                    {{-- Line Observations --}}
                    <div class="col-span-4">
                        <x-mary-textarea label="{{ __('Observations') }}" required rows="5"
                            wire:model='line_observation' />
                    </div>

                    <div x-show="$wire.line_code" class="flex col-span-4 justify-end">
                        <x-mary-button label="{{ __('Add Line') }}" icon="o-plus" class="rounded-s-none btn-success"
                            wire:click='addLine' spinner />
                    </div>
                </div>
                <div x-show="!$wire.id_item" class="mt-4"></div>
            </div>

            {{-- Item List --}}
            <x-mary-table :headers="$item_headers" :rows="$lines">
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
                    <div class="flex space-x-2">
                        <x-mary-button icon="o-arrows-right-left" class="btn-sm btn-warning text-white dark:text-black"
                            spinner wire:click="changeAmountColumn({{ $loop->index }})" x-show="$wire.isAvailable" />
                        <x-mary-button icon="o-minus-circle" class="btn-sm btn-error text-white dark:text-black" spinner
                            wire:click="removeLine({{ $row['item_id'] }})" x-show="$wire.isAvailable" />
                    </div>
                @endscope
            </x-mary-table>
        </x-mary-card>
    </section>

    {{-- Sección 3 : Totales --}}
    <section>
        <x-mary-card shadow class="mt-4">
            <div class="grid grid-cols-4 gap-4">
                <x-mary-input label="{{ __('Total Items') }}" wire:model="total_items"
                    readonly="{{ !$isAvailable }}" />
                <x-mary-input label="{{ __('Total Cash In') }}" wire:model="total_cash_in"
                    readonly="{{ !$isAvailable }}" />
                <x-mary-input label="{{ __('Total Cash Out') }}" wire:model="total_cash_out"
                    readonly="{{ !$isAvailable }}" />
                <x-mary-input label="{{ __('Total Balance') }}" wire:model="total_balance"
                    readonly="{{ !$isAvailable }}" />
            </div>
        </x-mary-card>
    </section>
</div>
