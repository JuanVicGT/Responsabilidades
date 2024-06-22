<x-layouts.app>
    @section('tab-title')
        {{ __('Edit Todo') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Edit Todo') }}" subtitle="{{ $todo->name }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-accent dark:btn-info"
                    link="{{ route('todo.index') }}" />
                <x-mary-button label="{{ __('Calendar View') }}" icon="o-calendar-days" class="btn-primary"
                    link="{{ route('todo.calendar') }}" no-wire-navigate />
                @if (auth()->user()->is_admin || auth()->user()->can('create_todo'))
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('todo.create') }}" />
                @endif
            </x-slot:actions>
        </x-mary-header>
    @endsection

    <x-mary-card shadow>
        {{-- Form --}}
        <x-mary-form method="POST" action="{{ route('todo.update') }}" x-data="{ submitButtonDisabled: false }"
            x-on:submit="submitButtonDisabled = true">
            @csrf
            @method('patch')

            <input type="hidden" name="id" value="{{ $todo->id }}">
            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <x-mary-input label="{{ __('Name') }}" type="text" name='name' required autofocus
                        value="{{ old('name', $todo->name) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-mary-select label="{{ __('Status') }}" name="status" option-value="value" :options="$status_options"
                        option-label="title" required placeholder="{{ old('status', __($current_status)) }}"
                        placeholder-value="{{ old('status', $todo->status) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>
                <div>
                    <x-mary-datetime label="{{ __('Date') }}" name="date" type="date"
                        value="{{ old('date', $todo->date) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('date')" />
                </div>
                <div>
                    <x-mary-datetime label="{{ __('Hour') }}" name="hour" type="time"
                        value="{{ old('hour', $todo->hour) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('hour')" />
                </div>
                <div class="col-span-2">
                    <x-mary-textarea label="{{ __('Description') }}" name="description" type="text"
                        rows="5">{{ old('description', $todo->description) }}</x-mary-textarea>
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

</x-layouts.app>
