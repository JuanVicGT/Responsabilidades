<x-mary-nav sticky full-width class="bg-base-200">

    <x-slot:brand>
        {{-- Drawer toggle for "main-drawer" --}}
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-mary-icon name="o-bars-3" class="cursor-pointer" />
        </label>

        {{-- Brand --}}
        <div>@yield('nav-title')</div>
    </x-slot:brand>

    @if ($user = auth()->user())
        {{-- Right side actions --}}
        <x-slot:actions class="max-h-8">
            <x-mary-theme-toggle class="btn btn-circle" />
            <x-mary-dropdown label="{{ $user->name }}" class="btn-outline">
                {{-- Use `@click.STOP` to stop event propagation --}}
                <x-mary-menu-item title="{{ __('Profile') }}" link="{{ route('profile.edit') }}" />

                {{-- Or `wire:click.stop`  --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <ul>
                        <li><button type="submit">{{ __('logout') }}</button></li>
                    </ul>
                </form>

            </x-mary-dropdown>
        </x-slot:actions>
    @endif
</x-mary-nav>
