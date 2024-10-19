@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/create-sheet.css') }}">
@endsection

<section>
    <x-mary-steps wire:model="current_step" shadow class="my-5 p-5 bg-base-100 rounded-lg">
        {{-- Step 1 : General Data --}}
        @include('livewire.backend.responsability.create_steps.step-1')
        {{-- Step 2 : Assign Items --}}
        @include('livewire.backend.responsability.create_steps.step-2')
        {{-- Step 3 : Verify Responsibilities --}}
        @include('livewire.backend.responsability.create_steps.step-3')
    </x-mary-steps>

    <div class="flex justify-between">
        <x-mary-button label="{{ __('Previous') }}" x-on:click="if ($wire.current_step > 1) $wire.current_step = $wire.current_step - 1"
            icon="m-arrow-uturn-left" class="btn-primary text-white" />

        {{-- Next or Save Button --}}
        <x-btn-save x-show="$wire.current_step === 3" wire:click="save" spinner />
        <x-mary-button x-show="$wire.current_step !== 3" label="{{ __('Next') }}" wire:click='nextStep' spinner
            icon="m-arrow-uturn-right" class="btn-primary text-white" />
    </div>

</section>
