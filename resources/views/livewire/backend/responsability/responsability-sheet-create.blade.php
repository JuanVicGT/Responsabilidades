@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/create-sheet.css') }}">
@endsection

<section>
    <x-mary-steps wire:model="step" shadow class="my-5 p-5 bg-base-100 rounded-lg">
        {{-- Step 1 : General Data --}}
        <x-mary-step step="1" text="{{ __('General Data') }}">
            <section class="grid grid-cols-4 gap-4">
                <div class="col-span-2">
                    <x-mary-input label="{{ __('Series') }}" wire:model="series" autofocus required />
                </div>
                <div class="col-span-2">
                    <x-mary-choices label="{{ __('Responsable') }}" wire:model="id_responsible" :options="$users" single
                        searchable icon="o-user" no-result-text="{{ __('No results found.') }}" required
                        class="max-h-12 external-choice">
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
            </section>
        </x-mary-step>
        {{-- Step 2 : Assign Items --}}
        <x-mary-step step="2" text="{{ __('Assign Items') }}">
            <section>
                <h2>{{ __('Assign Items') }}</h2>
            </section>
        </x-mary-step>
        {{-- Step 3 : Verify Responsibilities --}}
        <x-mary-step step="3" data-content="✓" text="{{ __('Verify Responsibilities') }}">
            <section>
                <h2>{{ __('Verify Responsibilities') }}</h2>
            </section>
        </x-mary-step>
    </x-mary-steps>

    <div class="flex justify-between">
        <x-mary-button label="{{ __('Previous') }}" x-on:click="if ($wire.step > 1) $wire.step = $wire.step - 1"
            icon="m-arrow-uturn-left" class="btn-primary text-white" />

        {{-- Next or Save Button --}}
        <x-btn-save x-show="$wire.step === 3" wire:click="save" spinner />
        <x-mary-button x-show="$wire.step !== 3" label="{{ __('Next') }}" wire:click='nextStep' spinner
            icon="m-arrow-uturn-right" class="btn-primary text-white" />
    </div>

</section>
