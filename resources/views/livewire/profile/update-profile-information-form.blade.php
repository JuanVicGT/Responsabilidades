<section>
    <x-mary-card title="{{ __('Profile Information') }}" subtitle="{{ __('Update your basic profile information.') }}"
        shadow separator>

        <x-mary-form wire:submit.prevent="save">
            @csrf
            @method('patch')

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <x-mary-input label="{{ __('Name') }}" type="text" wire:model='name' required autofocus
                        autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Last Name') }}" type="text" wire:model='last_name'
                        autocomplete="last_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Phone') }}" type="text" wire:model='phone' autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Email') }}" type="email" wire:model='email' autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                <div>
                    <x-mary-datetime label="{{ __('Birthdate') }}" wire:model="birthdate" wire:model='birthdate' />
                    <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Address') }}" type="text" wire:model='address'
                        autocomplete="address" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
                <div class="col-span-2 flex justify-center">
                    <div class="grid grid-cols-1">
                        <x-mary-file label="{{ __('Avatar') }}" wire:model="avatar" :preview="$avatar"
                            accept="image/png, image/jpeg, image/jpg" hint="{{ __('Only PNG, JPG') }}">
                            @if ($avatar_path)
                                <img src="{{ asset('storage/' . $avatar_path) }}" class="h-40 rounded-lg" />
                            @else
                                <img src="{{ asset('assets/images/no_image.jpg') }}" class="h-40 rounded-lg" />
                            @endif
                        </x-mary-file>
                        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                    </div>
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="{{ __('Save') }}" class="btn-success" type="submit" spinner="save" />
            </x-slot:actions>

        </x-mary-form>
    </x-mary-card>
</section>
