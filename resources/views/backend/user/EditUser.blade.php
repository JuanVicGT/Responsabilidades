<x-layouts.app>
    @section('tab-title')
        {{ __('Edit Collaborator') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Edit Collaborator') }}" subtitle="{{ $user->name }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-accent dark:btn-info"
                    link="{{ route('user.index') }}" />
                @if (auth()->user()->is_admin || auth()->user()->can('create_user'))
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('user.create') }}" />
                @endif
            </x-slot:actions>
        </x-mary-header>
    @endsection

    {{-- Form --}}
    <x-mary-card shadow>
        <x-mary-form method="POST" action="{{ route('user.update') }}" x-data="{ submitButtonDisabled: false }"
            x-on:submit="submitButtonDisabled = true">
            @csrf
            @method('patch')

            <input type="hidden" name="id" value="{{ $user->id }}">

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <x-mary-input label="{{ __('Code') }}" name="code" required autofocus
                        value="{{ old('code', $user->code) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('code')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Username') }}" name="username" required
                        value="{{ old('username', $user->username) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Name') }}" type="text" name='name' required
                        autocomplete="name" value="{{ old('name', $user->name) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-mary-select label="{{ __('Role') }}" icon="o-lock-closed" name="role" :options="$roles"
                        option-value="name" placeholder="{{ old('role', $currentRole->name ?? __('Select a Role')) }}"
                        placeholder-value="{{ old('role', $currentRole->name ?? null) }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Last Name') }}" type="text" name='last_name'
                        autocomplete="last_name" value="{{ old('last_name', $user->last_name) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Work Position') }}" name="work_position"
                        value="{{ old('work_position', $user->work_position) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('work_position')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Work Row') }}" name="work_row"
                        value="{{ old('work_row', $user->work_row) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('work_row')" />
                </div>
                <div>
                    <x-mary-select label="{{ __('Dependency') }}" icon="o-building-office-2" name="dependency"
                        :options="$dependencies" option-value="name" placeholder="{{ $user->dependency }}"
                        placeholder-value="{{ $user->dependency }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('dependency')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Phone') }}" type="text" name='phone' autocomplete="phone"
                        value="{{ old('phone', $user->phone) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Email') }}" type="email" name='email' autocomplete="email"
                        value="{{ old('email', $user->email) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                <div>
                    <x-mary-datetime label="{{ __('Birthdate') }}" name="birthdate" type="date" required
                        value="{{ old('birthdate', $user->birthdate) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Address') }}" type="text" name='address' autocomplete="address"
                        value="{{ old('address', $user->address) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
                <div class="flex items-center">
                    <x-mary-checkbox label="{{ __('Is Admin') }}" name="is_admin" tight
                        x-bind:checked="{{ old('is_admin', $user->is_admin) ? 1 : 0 }}" value="1" />
                    <x-input-error class="mt-2" :messages="$errors->get('is_admin')" />
                </div>
                <div class="flex items-center">
                    <x-mary-checkbox label="{{ __('Is Active') }}" name="is_active" tight
                        x-bind:checked="{{ old('is_active', $user->is_active) ? 1 : 0 }}" value="1" />
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                </div>
            </div>

            {{-- Submit Button --}}
            @if (auth()->user()->is_admin || auth()->user()->can('edit_user'))
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
            @endif

        </x-mary-form>
    </x-mary-card>

    {{-- Reset Password Form --}}
    <x-mary-card shadow class="!px-0" title="{{ __('Reset Password') }}">
        <x-mary-form method="POST" action="{{ route('user.update.password') }}" x-data="{ submitButtonDisabled: false }"
            x-on:submit="submitButtonDisabled = true">
            @csrf
            @method('patch')

            <input type="hidden" name="id" value="{{ $user->id }}">

            {{-- Submit Button --}}
            @if (auth()->user()->is_admin || auth()->user()->can('edit_user'))
                <div class="w-full mt-4 flex justify-start">
                    <x-mary-button type="submit" class="btn-success" x-bind:disabled="submitButtonDisabled">
                        <x-mary-loading class="text-primary" x-show="submitButtonDisabled" />
                        <div x-show="!submitButtonDisabled">
                            <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M403.8 34.4c12-5 25.7-2.2 34.9 6.9l64 64c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-64 64c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V160H352c-10.1 0-19.6 4.7-25.6 12.8L284 229.3 244 176l31.2-41.6C293.3 110.2 321.8 96 352 96h32V64c0-12.9 7.8-24.6 19.8-29.6zM164 282.7L204 336l-31.2 41.6C154.7 401.8 126.2 416 96 416H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H96c10.1 0 19.6-4.7 25.6-12.8L164 282.7zm274.6 188c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V416H352c-30.2 0-58.7-14.2-76.8-38.4L121.6 172.8c-6-8.1-15.5-12.8-25.6-12.8H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H96c30.2 0 58.7 14.2 76.8 38.4L326.4 339.2c6 8.1 15.5 12.8 25.6 12.8h32V320c0-12.9 7.8-24.6 19.8-29.6s25.7-2.2 34.9 6.9l64 64c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-64 64z" />
                            </svg> {{ __('Generate Password') }}
                        </div>
                    </x-mary-button>
                </div>
            @endif

        </x-mary-form>
    </x-mary-card>

</x-layouts.app>
