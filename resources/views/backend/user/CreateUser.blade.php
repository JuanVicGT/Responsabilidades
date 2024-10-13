<x-layouts.app>
    {{-- Tab Title --}}
    @section('tab-title')
        {{ __('Add New') }}
    @endsection

    {{-- Header --}}
    @section('content-header')
        <x-mary-header title="{{ __('Add New Collaborator') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-accent dark:btn-info"
                    link="{{ route('user.index') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endsection

    {{-- Form --}}
    <x-mary-card shadow>
        <x-mary-form method="POST" action="{{ route('user.store') }}" x-data="{ submitButtonDisabled: false }"
            x-on:submit="submitButtonDisabled = true">
            @csrf

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <x-mary-input label="{{ __('Username') }}" name="username" required value="{{ old('username') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Name') }}" type="text" name='name' required autocomplete="name"
                        value="{{ old('name') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-mary-select label="{{ __('Role') }}" icon="o-lock-closed" name="role" :options="$roles"
                        option-value="name" placeholder="{{ old('role', __('Select a Role')) }}"
                        placeholder-value="{{ old('role', null) }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('dependency')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Last Name') }}" type="text" name='last_name'
                        autocomplete="last_name" value="{{ old('last_name') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Work Position') }}" name="work_position"
                        value="{{ old('work_position') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('work_position')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Work Row') }}" name="work_row" value="{{ old('work_row') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('work_row')" />
                </div>
                <div>
                    <x-mary-select label="{{ __('Dependency') }}" icon="o-building-office-2" name="dependency"
                        :options="$dependencies" option-value="name" placeholder="{{ __('Select Dependency') }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('dependency')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Phone') }}" type="text" name='phone' autocomplete="phone"
                        value="{{ old('phone') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Email') }}" type="email" name='email' autocomplete="email"
                        value="{{ old('email') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                <div>
                    <x-mary-datetime label="{{ __('Birthdate') }}" name="birthdate" type="date" required
                        value="{{ old('birthdate') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Address') }}" type="text" name='address' autocomplete="address"
                        value="{{ old('address') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
                <div class="flex items-center">
                    <x-mary-checkbox label="{{ __('Is Admin') }}" name="is_admin" tight
                        x-bind:checked="{{ old('is_admin') ? 1 : 0 }}" value="1" />
                    <x-input-error class="mt-2" :messages="$errors->get('admin')" />
                </div>
                <div class="flex items-center">
                    <x-mary-checkbox label="{{ __('Is Active') }}" name="is_active" tight
                        x-bind:checked="{{ old('is_active', 1) ? 1 : 0 }}" value="1" />
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
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
