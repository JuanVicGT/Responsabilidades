<section class="mt-6">
    <x-mary-card title="{{ __('Update Password') }}"
        subtitle="{{ __('Ensure your account is using a long, random password to stay secure.') }}" shadow separator>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="grid sm:grid-cols-1 gap-4">

                <div x-data="{ show_1: false }">
                    <span>{{ __('Current Password') }}</span>
                    <div class="flex items-center">
                        <input id="update_password_current_password" name="current_password"
                            class="input input-primary w-full peer" autocomplete="current-password"
                            :type="show_1 ? 'text' : 'password'">
                        <a class="absolute right-8 cursor-pointer" :class="{ 'hidden': !show_1, 'block': show_1 }"
                            @click="show_1 = !show_1"><i class="fa-solid fa-eye"></i></a>
                        <a class="absolute right-8 cursor-pointer" :class="{ 'hidden': show_1, 'block': !show_1 }"
                            @click="show_1 = !show_1"><i class="fa-solid fa-eye-slash"></i></a>
                        </input>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div x-data="{ show_2: false }">
                    <span>{{ __('New Password') }}</span>
                    <div class="flex items-center">
                        <input id="update_password_password" name="password" class="input input-primary w-full peer"
                            autocomplete="new-password" :type="show_2 ? 'text' : 'password'">
                        <a class="absolute right-8 cursor-pointer" :class="{ 'hidden': !show_2, 'block': show_2 }"
                            @click="show_2 = !show_2"><i class="fa-solid fa-eye"></i></a>
                        <a class="absolute right-8 cursor-pointer" :class="{ 'hidden': show_2, 'block': !show_2 }"
                            @click="show_2 = !show_2"><i class="fa-solid fa-eye-slash"></i></a>
                        </input>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div x-data="{ show_3: false }">
                    <span>{{ __('Confirm Password') }}</span>
                    <div class="flex items-center">
                        <input id="update_password_password_confirmation" name="password_confirmation"
                            class="input input-primary w-full peer" autocomplete="new-password"
                            :type="show_3 ? 'text' : 'password'">
                        <a class="absolute right-8 cursor-pointer" :class="{ 'hidden': !show_3, 'block': show_3 }"
                            @click="show_3 = !show_3"><i class="fa-solid fa-eye"></i></a>
                        <a class="absolute right-8 cursor-pointer" :class="{ 'hidden': show_3, 'block': !show_3 }"
                            @click="show_3 = !show_3"><i class="fa-solid fa-eye-slash"></i></a>
                        </input>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-6">
                <x-mary-button label="{{ __('Save') }}" class="btn-success" type="submit" spinner />
            </div>

        </form>
    </x-mary-card>
</section>
