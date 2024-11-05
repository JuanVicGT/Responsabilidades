<div>
    {{-- Form --}}
    <x-mary-card shadow>
        <div>
            {{-- Sección 1 : Información general --}}
            <section>
                <x-mary-card shadow>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="col-span-2">
                            <x-mary-input label="{{ __('Number') }}" value="{{ $sheet->number }}" required readonly />
                        </div>
                        <div class="col-span-2">
                            <x-mary-input label="{{ __('Responsible') }}" value="{{ $sheet->responsible->name }}"
                                readonly />
                        </div>

                        {{-- Crate Info --}}
                        <div>
                            <x-mary-input label="{{ __('Create Date') }}" icon="o-calendar" type="text"
                                value="{{ $sheet->created_at }}" readonly />
                        </div>
                        <div>
                            <x-mary-input label="{{ __('Crate By') }}" value="{{ $sheet->creator->name }}" readonly />
                        </div>

                        {{-- Edit Info --}}
                        <div>
                            <x-mary-input label="{{ __('Last Update') }}" icon="o-calendar" type="text"
                                value="{{ $sheet->updated_at ?? '' }}" readonly />
                        </div>
                        <div>
                            <x-mary-input label="{{ __('Last Update By') }}" value="{{ $sheet->updater->name ?? '' }}"
                                readonly />
                        </div>

                        {{-- Status --}}
                        <div class="col-span-4">
                            <x-mary-input label="{{ __('Status') }}" value="{{ ucfirst(__($sheet->status)) }}"
                                readonly />
                        </div>
                    </div>
                </x-mary-card>
            </section>

            {{-- Sección 2 : Sección de items --}}
            <section>
                <x-mary-card shadow class="mt-4">
                    {{-- Item List --}}
                    <x-mary-table :headers="$item_headers" :rows="$sheet->lines">
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
                    </x-mary-table>
                </x-mary-card>
            </section>

            {{-- Sección 3 : Totales --}}
            <section>
                <x-mary-card shadow class="mt-4">
                    <div class="grid grid-cols-4 gap-4">
                        <x-mary-input label="{{ __('Total Cash In') }}" value="Q {{ $sheet->cash_in }}" readonly />
                        <x-mary-input label="{{ __('Total Cash Out') }}" value="Q {{ $sheet->cash_out }}" readonly />
                        <x-mary-input label="{{ __('Total Balance') }}" value="Q {{ $sheet->balance }}" readonly />
                    </div>
                </x-mary-card>
            </section>
        </div>

    </x-mary-card>
</div>
