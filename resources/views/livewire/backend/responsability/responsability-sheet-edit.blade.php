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

                {{-- Crate Info --}}
                <div>
                    <x-mary-input label="{{ __('Create Date') }}" icon="o-calendar" type="text"
                        value="{{ $created_at }}" readonly />
                </div>
                <div>
                    <x-mary-input label="{{ __('Crate By') }}" wire:model="created_name" readonly />
                </div>

                {{-- Edit Info --}}
                <div>
                    <x-mary-input label="{{ __('Last Update') }}" icon="o-calendar" type="text"
                        value="{{ $updated_at }}" readonly />
                </div>
                <div>
                    <x-mary-input label="{{ __('Last Update By') }}" wire:model="updated_name" readonly />
                </div>

                {{-- Status --}}
                <div class="col-span-4">
                    <x-mary-input label="{{ __('Status') }}" wire:model="status_translate" readonly />
                </div>
            </div>

            {{-- Botones para cuando esta disponible la hoja --}}
            @if ($isAvailable)
                <div class="flex col-span-4 justify-between mt-2">
                    <x-mary-button label="{{ __('Block Sheet') }}" icon="o-lock-closed" class=" btn-warning" spinner
                        wire:click="blockSheet" />
                    <x-btn-save spinner wire:click="save" />
                </div>
            @endif

            {{-- Botones para cuando esta bloqueada la hoja --}}
            @if ($status === App\Utils\Enums\ResponsabilitySheetStatusEnum::Closed->value)
                <div class="flex col-span-4 justify-between mt-2">
                    <x-mary-button label="{{ __('Print') }}" icon="o-printer" class=" btn-accent" spinner
                        link="{{ route('responsability-sheet.print', ['id' => $id]) }}" external />
                    <x-mary-button label="{{ __('Make Transfer') }}" icon="o-arrows-right-left" class=" btn-warning"
                        spinner @click="$wire.show_transfer_modal = true" />
                </div>
            @endif

            {{-- Botones para cuando la hoja ha sido transferida --}}
            @if ($status === App\Utils\Enums\ResponsabilitySheetStatusEnum::Transferred->value)
                <div class="flex col-span-4 justify-between mt-2">
                    <x-mary-button label="{{ __('Print') }}" icon="o-printer" class=" btn-accent" spinner
                        link="{{ route('responsability-sheet.print', ['id' => $id]) }}" external />
                </div>
            @endif
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
                        <x-mary-button label="{{ __('Load Item') }}" icon="o-plus" class=" btn-accent dark:btn-info"
                            wire:click='loadItem' spinner />
                    </x-slot:append>
                </x-mary-choices>

                @if ($canCreate)
                    <div x-show="$wire.show_create_btn" class="flex col-span-4 justify-center mt-2">
                        <x-mary-button label="{{ __('Create New Item') }}" icon="o-plus" class=" btn-info"
                            x-on:click="$wire.show_form = !$wire.show_form" />
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
                        <x-mary-button label="{{ __('Add Line') }}" icon="o-plus" class=" btn-success"
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

    {{-- Sección 4 : Modals --}}
    @if ($status === App\Utils\Enums\ResponsabilitySheetStatusEnum::Closed->value)
        <x-mary-modal wire:model="show_transfer_modal" class="backdrop-blur" box-class="min-w-[24rem] max-w-[64rem]">
            <x-mary-header title="{{ __('Transfer Modal Title') }}" subtitle="{{ __('Transfer Modal Subtitle') }}"
                class="mb-2" separator />

            {{-- Description --}}
            <div>
                <p>{{ __('Transfer Modal Notice') }}</p>
                <ul class="list-disc pl-4">
                    @if ($transfer_second_method)
                        <li>{{ __('Transfer Modal Notice 7') }}</li>
                        <li>{{ __('Transfer Modal Notice 3') }}</li>
                        <li>{{ __('Transfer Modal Notice 4') }}</li>
                        <li>{{ __('Transfer Modal Notice 6') }}</li>
                    @else
                        <li>{{ __('Transfer Modal Notice 1') }}</li>
                        <li>{{ __('Transfer Modal Notice 2') }}</li>
                        <li>{{ __('Transfer Modal Notice 3') }}</li>
                        <li>{{ __('Transfer Modal Notice 4') }}</li>
                        <li>{{ __('Transfer Modal Notice 5') }}</li>
                        <li>{{ __('Transfer Modal Notice 6') }}</li>
                    @endif
                </ul>
            </div>

            <hr class="my-4">

            <div class="min-h-96">
                {{-- Select new responsable --}}
                <x-mary-choices label="{{ __('Transfer To') }}" debounce="500ms" wire:model="transfer_responsible_id"
                    name="responsible_id" single icon="o-user" no-result-text="{{ __('No results found.') }}"
                    required class="max-h-16 external-choice" :options="$option_users" searchable
                    search-function="searchUsers">
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

                @foreach ($lines as $line)
                    @if ($line['cash_in'] > 0)
                        <div class="flex items-center justify-start mt-4">
                            <label
                                class="w-full flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 [&:has(input:checked)]:text-black dark:[&:has(input:checked)]:text-white [&:has(input:disabled)]:opacity-75 [&:has(input:disabled)]:cursor-not-allowed">

                                <div class="flex items-center w-full">
                                    <div class="relative flex items-center">
                                        <input type="checkbox"
                                            class="before:content[''] peer relative size-4 cursor-pointer appearance-none overflow-hidden rounded border border-slate-300 bg-slate-100 before:absolute before:inset-0 checked:border-blue-700 checked:before:bg-blue-700 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-blue-700 active:outline-offset-0 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-800 dark:checked:border-blue-600 dark:checked:before:bg-blue-600 dark:focus:outline-slate-300 dark:checked:focus:outline-blue-600"
                                            wire:click='updateTransferLine({{ $line['line_id'] }}, $event.target.checked)'
                                            @click="$wire.show_transfer_btn = false" />
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            aria-hidden="true" stroke="currentColor" fill="none" stroke-width="4"
                                            class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/2 text-slate-100 peer-checked:visible dark:text-slate-100">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>

                                    <div class="grid grid-cols-1 ml-6 w-full">
                                        <span class="w-full">{{ $line['description'] }}</span>
                                        <span
                                            class="w-full text-sm text-slate-700 dark:text-slate-300">{{ $line['code'] }}</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <hr class="my-4">
                    @endif
                @endforeach
            </div>

            <div>
                <p class="text-center">
                    {{ __('Transfer Count Items Selected', ['count' => count($transfer_lines)]) }}
                </p>
            </div>

            <div class="flex col-span-4 justify-between mt-2">
                <x-mary-button label="Cancel" @click="$wire.show_transfer_modal = false" />
                <x-mary-button x-show="$wire.show_transfer_btn" label="{{ __('Make Transfer') }}"
                    icon="o-arrows-right-left" class="btn-warning" spinner wire:click="makeTransfer" />
            </div>
        </x-mary-modal>
    @endif
</div>
