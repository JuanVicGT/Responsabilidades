<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

    {{-- BRAND --}}
    <div class="mary-hideable">
        <div class="pt-5 grid place-items-center w-full">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="w-24 h-24 text-gray-500 object-contain" />
            </a>
            <span class="text-center mt-2">{{ __('Work Rights') }}</span>
        </div>
    </div>

    {{-- MENU --}}
    <x-mary-menu activate-by-route active-bg-color="bg-sky-500/20" class="-mt-3">

        {{-- User --}}
        @if ($user = auth()->user())
            <x-mary-menu-separator />

            {{-- Avatar, Name and Work_position --}}
            <x-mary-list-item :item="$user" value="name" sub-value="work_position" no-separator no-hover
                class="-mx-2 !-my-2 rounded" link="{{ route('profile.edit') }}">
                <x-slot:avatar>
                    @if ($user->avatar)
                        <x-mary-avatar image="{{ asset('storage/' . $user->avatar) }}" class="!w-10" />
                    @else
                        <x-mary-avatar image="{{ asset('assets/images/no_image.jpg') }}" class="!w-10" />
                    @endif
                </x-slot:avatar>

                {{-- Actions --}}
                <x-slot:actions>
                    <x-mary-dropdown>
                        <x-slot:trigger no-separator no-hover class="!-my-2 rounded">
                            <x-mary-button icon="o-cog-6-tooth" class="btn-circle" />
                        </x-slot:trigger>

                        <x-mary-menu-item title="{{ __('Profile') }}" icon="o-user"
                            link="{{ route('profile.edit') }}" />
                        <x-mary-menu-item title="{{ __('Change Theme') }}" icon="o-swatch" @click.stop=""
                            @click="$dispatch('mary-toggle-theme')" />

                        <x-mary-menu-separator />

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="flex">
                            @csrf
                            <button type="submit" class="w-full">
                                <x-mary-menu-item title="{{ __('Logout') }}" icon="o-power" />
                            </button>
                        </form>
                    </x-mary-dropdown>
                </x-slot:actions>
            </x-mary-list-item>

            <x-mary-menu-separator />
        @endif

        {{-- Sección General --}}
        <x-mary-menu-item title="{{ __('Dashboard') }}" icon="o-home" link="{{ route('dashboard') }}"
            no-wire-navigate />
        @if (auth()->user()->is_admin || auth()->user()->can('index_event'))
            <x-mary-menu-item title="{{ __('Events') }}" icon="o-calendar-days" link="{{ route('event.index') }}" />
        @endif
        @if (auth()->user()->is_admin || auth()->user()->can('index_todo'))
            <x-mary-menu-sub title="{{ __('Todos') }}" icon="o-clipboard-document-check">
                <x-mary-menu-item title="{{ __('List') }}" icon="o-list-bullet" link="{{ route('todo.index') }}" />
                <x-mary-menu-item title="{{ __('Calendar') }}" icon="o-calendar-days"
                    link="{{ route('todo.calendar') }}" no-wire-navigate />
            </x-mary-menu-sub>
        @endif
        @if (auth()->user()->is_admin || auth()->user()->can('index_attendance'))
            <x-mary-menu-item title="{{ __('Attendances') }}" icon="o-clock" link="{{ route('attendance.index') }}" />
        @endif

        {{-- Sección de RH --}}
        @if (auth()->user()->is_admin || auth()->user()->can('index_user'))
            <span class="text-lg font-bold flex items-center">
                <hr class="w-full mx-4">
                <p class="mary-hideable mr-2">{{ __('HR') }}</p>
            </span>
        @endif
        @if (auth()->user()->is_admin || auth()->user()->can('index_role'))
            <x-mary-menu-item title="{{ __('Roles') }}" icon="o-user-plus" link="{{ route('role.index') }}" />
        @endif
        @if (auth()->user()->is_admin || auth()->user()->can('index_permission'))
            <x-mary-menu-item title="{{ __('Permissions') }}" icon="o-lock-open"
                link="{{ route('permission.index') }}" />
        @endif
        @if (auth()->user()->is_admin || auth()->user()->can('index_dependency'))
            <x-mary-menu-item title="{{ __('Dependencies') }}" icon="o-building-office-2"
                link="{{ route('dependency.index') }}" />
        @endif
        @if (auth()->user()->is_admin || auth()->user()->can('index_user'))
            <x-mary-menu-item title="{{ __('Collaborators') }}" icon="o-user-group"
                link="{{ route('user.index') }}" />
        @endif

        {{-- Sección de responsabilidades --}}
        <span class="text-lg font-bold flex items-center">
            <hr class="w-full mx-4">
            <p class="mary-hideable mr-2">{{ __('Responsibilities') }}</p>
        </span>
        @if (auth()->user()->is_admin || auth()->user()->can('index_item'))
            <x-mary-menu-item title="{{ __('Items') }}" icon="o-rectangle-group" link="{{ route('item.index') }}" />
        @endif
        @if (auth()->user()->is_admin || auth()->user()->can('index_responsibility'))
            <x-mary-menu-item title="{{ __('Responsability Sheets') }}" icon="c-clipboard-document-check"
                link="{{ route('responsability-sheet.index') }}" />
        @endif
    </x-mary-menu>
</x-slot:sidebar>
