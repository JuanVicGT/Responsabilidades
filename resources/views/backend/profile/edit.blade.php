<x-layouts.app>
    @section('tab-title')
        {{ __('Edit Profile') }}
    @endsection

    @section('content-header')
        <div class="flex justify-between">
            <x-mary-header title="{{ $user->name }}" subtitle="{{ __('Edit Profile') }}" class="mb-4" />
            <div class="flex items-center space-x-4">
                <x-mary-theme-toggle label="{{ __('Change Theme') }}" />
                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="flex">
                    @csrf
                    <x-mary-button type="submit" label="{{ __('Logout') }}" icon="o-power" />
                </form>
            </div>
        </div>
    @endsection

    <!-- MARY UI BASIC INFORMATION FORM -->
    <livewire:profile.update-profile-information-form :user="$user" />

    <!-- ORIGINAL DESIGN -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @include('backend.profile.partials.update-password-form')

</x-layouts.app>
