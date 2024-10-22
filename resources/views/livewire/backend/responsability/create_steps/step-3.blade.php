<x-mary-step step="3" data-content="✓" text="{{ __('Verify Responsibilities') }}">
    <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="col-span-2">
            <x-mary-input label="{{ __('Number') }}" wire:model="form_step1_number" readonly />
        </div>
        <div class="col-span-2">
            <x-mary-input label="{{ __('Responsible') }}" wire:model="form_step1_name_responsible" readonly />
        </div>
    </section>
    {{-- Section 2 : Items assigned --}}
    <section class="grid grid-cols-1 mt-4">
        <hr class="w-full h-1 mt-2 mb-4 bg-gray-300">
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

        {{-- Section 3 : Totals --}}
        <section class="grid grid-cols-4 gap-4 mt-4">
            <hr class="col-span-4 w-full h-1 bg-gray-300">
            <x-mary-input label="{{ __('Total Items') }}" wire:model="step3_total_items" readonly />
            <x-mary-input label="{{ __('Total Cash In') }}" wire:model="step3_total_cash_in" readonly />
            <x-mary-input label="{{ __('Total Cash Out') }}" wire:model="step3_total_cash_out" readonly />
            <x-mary-input label="{{ __('Total Balance') }}" wire:model="step3_total_balance" readonly />
        </section>
    </section>
</x-mary-step>
