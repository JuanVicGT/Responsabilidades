<x-layouts.app>
    @section('tab-title')
        {{ __('Password Reset Requests') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Password Reset Requests') }}">
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.prequest.prequest-table />
    </div>

</x-layouts.app>
