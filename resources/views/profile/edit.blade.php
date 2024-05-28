<x-layouts.app>
    <x-mary-header title="{{ $user->name }}" subtitle="{{ __('Edit Profile') }}" />

    <!-- MARY UI BASIC INFORMATION FORM -->
    <livewire:profile.update-profile-information-form :user="$user" />

    <!-- ORIGINAL DESIGN -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @include('profile.partials.update-password-form')

</x-layouts.app>
