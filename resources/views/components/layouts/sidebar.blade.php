<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

    {{-- BRAND --}}
    <div class="ml-5 pt-5">App</div>

    {{-- MENU --}}
    <x-mary-menu activate-by-route active-bg-color="bg-sky-500/20">
        <x-mary-theme-toggle class="hidden" />

        {{-- User --}}
        @if ($user = auth()->user())
            <x-mary-menu-separator />

            {{-- All slots --}}
            <x-mary-list-item :item="$user" value="name" sub-value="cargo" no-separator no-hover class="-mx-2 !-my-2 rounded">
                <x-slot:avatar>
                    <x-mary-avatar image="{{ $user->avatar ?? asset('assets/images/no_image.jpg') }}" class="!w-10" />
                </x-slot:avatar>
                <x-slot:actions>
                    <x-mary-dropdown>
                        <x-slot:trigger no-separator no-hover class="!-my-2 rounded">
                            <x-mary-button icon="o-cog-6-tooth" class="btn-circle" />
                        </x-slot:trigger>

                        {{-- Or `wire:click.stop`  --}}
                        <form method="POST" action="{{ route('logout') }}" class="flex">
                            @csrf
                            <button type="submit">
                                <x-mary-menu-item title="{{ __('Logout') }}" icon="o-power" />
                            </button>
                        </form>
                        <x-mary-menu-item title="{{ __('Change Theme') }}" icon="o-swatch" @click.stop=""
                            @click="$dispatch('mary-toggle-theme')" />
                    </x-mary-dropdown>
                </x-slot:actions>
            </x-mary-list-item>

            <x-mary-menu-separator />
        @endif

        {{-- Activates the menu item when a route matches the `link` property --}}
        <x-mary-menu-item title="{{ __('home') }}" icon="o-home" link="{{ route('dashboard') }}" />

        {{-- Sección de RH --}}
        <x-mary-menu-item title="{{ __('Collaborators') }}" icon="o-user-group" link="###" />

        {{-- Sección de responsabilidades --}}
        <x-mary-menu-item title="{{ __('list-docs') }}" icon="c-clipboard-document-check" link="###" />
        <x-mary-menu-item title="{{ __('settings') }}" icon="o-cog-6-tooth" link="###" />
    </x-mary-menu>
</x-slot:sidebar>
