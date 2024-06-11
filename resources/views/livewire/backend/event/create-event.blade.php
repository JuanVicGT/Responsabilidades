@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom-mary.css') }}">
@endsection

<x-mary-card shadow>
    <x-mary-form method="POST" action="{{ route('event.store') }}" x-data="{ submitButtonDisabled: false }"
        x-on:submit="submitButtonDisabled = true">
        @csrf

        <div class="grid sm:grid-cols-4 gap-4">
            <div class="col-span-2">
                <x-mary-input label="{{ __('Name') }}" type="text" name='name' required
                    value="{{ old('name') }}" autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-mary-select label="{{ __('Status') }}" name="status" option-value="value" :options="$status_options"
                    option-label="title" placeholder="{{ old('status') }}" placeholder-value="{{ old('status') }}"
                    required />
                <x-input-error class="mt-2" :messages="$errors->get('status')" />
            </div>
            <div>
                <input type="text" name="id_responsible" x-model="$wire.id_responsible" x-readonly hidden>
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
                <x-input-error class="mt-2" :messages="$errors->get('status')" />
            </div>
            <div class="col-span-2">
                <x-mary-datetime label="{{ __('Start Date') }}" name="start_date" type="date" required
                    value="{{ old('start_date') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
            </div>
            <div class="col-span-2">
                <x-mary-datetime label="{{ __('End Date') }}" name="end_date" type="date" required
                    value="{{ old('end_date') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
            </div>
            <div class="col-span-2">
                <x-mary-datetime label="{{ __('Start Hour') }}" name="start_hour" type="time"
                    value="{{ old('start_hour') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('start_hour')" />
            </div>
            <div class="col-span-2">
                <x-mary-datetime label="{{ __('End Hour') }}" name="end_hour" type="time"
                    value="{{ old('end_hour') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('end_hour')" />
            </div>
            <div class="col-span-4">
                <x-mary-textarea label="{{ __('Description') }}" name="description" type="time" rows="5"
                    inline>{{ old('description') }}</x-mary-textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="w-full mt-4 flex justify-end">
            <x-mary-button type="submit" class="btn-success" x-bind:disabled="submitButtonDisabled">
                <x-mary-loading class="text-primary" x-show="submitButtonDisabled" />
                <div x-show="!submitButtonDisabled">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M48 96V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V170.5c0-4.2-1.7-8.3-4.7-11.3l33.9-33.9c12 12 18.7 28.3 18.7 45.3V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H309.5c17 0 33.3 6.7 45.3 18.7l74.5 74.5-33.9 33.9L320.8 84.7c-.3-.3-.5-.5-.8-.8V184c0 13.3-10.7 24-24 24H104c-13.3 0-24-10.7-24-24V80H64c-8.8 0-16 7.2-16 16zm80-16v80H272V80H128zm32 240a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z" />
                    </svg> {{ __('Save') }}
                </div>
            </x-mary-button>
        </div>

    </x-mary-form>
</x-mary-card>
