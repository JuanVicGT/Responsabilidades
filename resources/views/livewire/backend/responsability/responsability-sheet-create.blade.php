<section>
    <style>
        .steps .step-primary::after {
            color: white;
            font-weight: bold;
        }

        .steps .step-primary::before {
            background-color: var(--fallback-p, oklch(var(--p)/var(--tw-bg-opacity)));
        }

        .steps {
            @media (min-width: 768px) {
                width: 100%;
            }
        }
    </style>

    <x-mary-steps wire:model="step" shadow class="my-5 p-5 bg-slate-100 dark:bg-slate-800 rounded-lg">
        <x-mary-step step="1" text="{{ __('General Data') }}">
            Register step
        </x-mary-step>
        <x-mary-step step="2" text="{{ __('Assign Items') }}">
            <x-mary-input wire:model="test_val" label="CAP"></x-mary-input>
        </x-mary-step>
        <x-mary-step step="3" data-content="✓" text="{{ __('Verify Responsibilities') }}">
            Receive Product
        </x-mary-step>
    </x-mary-steps>

    <div class="flex justify-between">
        <x-mary-button label="{{ __('Previous') }}" x-on:click="if ($wire.step > 1) $wire.step = $wire.step - 1"
            icon="m-arrow-uturn-left" class="btn-primary text-white" />

        {{-- Next or Save Button --}}
        <x-btn-save x-show="$wire.step === 3" wire:click="save" spinner />
        <x-mary-button x-show="$wire.step !== 3" label="{{ __('Next') }}"
            x-on:click="if ($wire.step < 3) $wire.step = $wire.step + 1" icon="m-arrow-uturn-right"
            class="btn-primary text-white" />
    </div>

</section>
