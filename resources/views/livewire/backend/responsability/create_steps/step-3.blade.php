<x-mary-step step="3" data-content="✓" text="{{ __('Verify Responsibilities') }}">
    <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="col-span-2">
            <x-mary-input label="{{ __('Number') }}" wire:model="form_step1_number" readonly />
        </div>
        <div class="col-span-2">
            <x-mary-input label="{{ __('Responsible') }}" wire:model="form_step1_name_responsible" readonly />
        </div>
        <div class="col-span-2">
            <x-mary-input label="{{ __('Responsible') }}" wire:model="form_step1_name_responsible" readonly />
        </div>
        <div class="col-span-2">

        </div>
    </section>
</x-mary-step>
