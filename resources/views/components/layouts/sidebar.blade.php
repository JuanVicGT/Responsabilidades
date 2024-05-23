<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

    {{-- Activates the menu item when a route matches the `link` property --}}
    <x-mary-menu activate-by-route active-bg-color="bg-sky-500/20">
        <x-mary-menu-item title="{{ __('home') }}" icon="o-home" link="{{ route('dashboard') }}" />
        <x-mary-menu-item title="{{ __('customers') }}" icon="o-user-group" link="###" />
        <x-mary-menu-item title="{{ __('list-docs') }}" icon="c-clipboard-document-check" link="###" />
        <x-mary-menu-item title="{{ __('settings') }}" icon="o-cog-6-tooth" link="###" />
    </x-mary-menu>
</x-slot:sidebar>
